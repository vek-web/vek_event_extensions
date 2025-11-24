<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Backend\Controller\RecordListController;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use ReflectionObject;
use Psr\Http\Message\StreamFactoryInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Vek\EventExtensions\Domain\Model\Event;
use Vek\EventExtensions\Domain\Repository\EventRepository;
use Vek\EventExtensions\Domain\Model\Registration;
use DERHANSEN\SfEventMgt\Domain\Repository\RegistrationRepository;
use DERHANSEN\SfEventMgt\Service\FluidRenderingService;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\Mailer;
use Symfony\Component\Mime\Address;
use Dompdf\Dompdf;
use Dompdf\Options;
use DateTime;
use Vek\EventExtensions\Utility\EmailAddressUtility;
use TYPO3\CMS\Core\Localization\LanguageService;

#[AsController]
/**
 * Class EventExtensionsModuleController
 *
 * Backend module controller providing actions to manage and send event-related
 * emails (meeting links, certificates) and to preview certificates.
 */
final class EventExtensionsModuleController extends ActionController
{
    private const LANG_FILE = 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_be.xlf:';

    /**
     * EventExtensionsModuleController constructor.
     *
     * @param ModuleTemplateFactory $moduleTemplateFactory
     * @param EventRepository $eventRepository
     * @param RegistrationRepository $registrationRepository
     * @param PersistenceManager $persistenceManager
     * @param FluidRenderingService $fluidRenderingService
     */
    public function __construct(
        protected readonly ModuleTemplateFactory  $moduleTemplateFactory,
        protected readonly EventRepository        $eventRepository,
        protected readonly RegistrationRepository $registrationRepository,
        protected readonly PersistenceManager     $persistenceManager,
        protected readonly FluidRenderingService $fluidRenderingService,
    )
    {
    }

    /**
     * Display the record list for registrations.
     *
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $pageId = (int)$this->request->getArgument('id');
        return $this->getRecords($this->request, 'tx_sfeventmgt_domain_model_registration', $pageId);
    }

    /**
     * Send meeting link emails for an event's registrations.
     *
     * @param int $id
     * @param int $event
     * @return ResponseInterface
     */
    public function sendlinkAction(int $id, int $event): ResponseInterface
    {
        $event = $this->eventRepository->findByUidIncludeHidden($event ?? 0);
        $from = EmailAddressUtility::getSenderAddress('meeting', $this->settings);
        $num = 0;

        if ($from !== null) {
            foreach ($event->getRegistrations() as $registration) {
                if ($registration->getConfirmed() && !$registration->getLinksent()) {
                    $this->sendMeetingLinkMail($registration, $event, $from, $this->settings, $this->request);
                    $registration->setLinksent(true);
                    $this->registrationRepository->update($registration);
                    $num++;
                }
            }

            $this->persistenceManager->persistAll();
        }

        $message = GeneralUtility::makeInstance(FlashMessage::class,
            sprintf($this->getLanguageService()->sL(self::LANG_FILE . 'eventextensionmodulecontroller_sendlinkAction_message'), $num),
            $this->getLanguageService()->sL(self::LANG_FILE . 'eventextensionmodulecontroller_sendlinkAction_message_after'),
            $num > 0 ? ContextualFeedbackSeverity::OK : ContextualFeedbackSeverity::WARNING,
            true
        );
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();

        $messageQueue->addMessage($message);

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $pageUid = $id ?? 0;
        $uri = (string)$uriBuilder->buildUriFromRoute('tx_sfeventmgt.Administration_list', ['id' => $pageUid]);

        return $this->responseFactory->createResponse()->withHeader('Location', $uri);
    }

    /**
     * Send certificates as PDF attachments to registrations.
     *
     * @param int $id
     * @param int $event
     * @return ResponseInterface
     */
    public function sendcertificateAction(int $id, int $event): ResponseInterface
    {
        $event = $this->eventRepository->findByUidIncludeHidden($event ?? 0);
        $from = EmailAddressUtility::getSenderAddress('certificate', $this->settings);
        $num = 0;

        if ($from !== null) {
            foreach ($event->getRegistrations() as $registration) {
                if (($registration->getCertificate() === 1 || $registration->getCertificate() === 2)
                    && $registration->getCertificateSent() === false
                    && $registration->getCertificatecompliance() === true) {
                    $html = $this->renderTeilnahmeHtml($event, $registration);
                    $dompdf = $this->getTeilnahmeDomPdf($html);
                    $this->sendCertificateMail($registration, $event, $dompdf, $from, $this->settings, $this->request);
                    $registration->setCertificateSent(true);
                    $this->registrationRepository->update($registration);
                    $num++;
                }
            }

            $this->persistenceManager->persistAll();
        }

        $message = GeneralUtility::makeInstance(FlashMessage::class,
            sprintf($this->getLanguageService()->sL(self::LANG_FILE . 'eventextensionmodulecontroller_sendcertificateAction_message'), $num),
            $this->getLanguageService()->sL(self::LANG_FILE . 'eventextensionmodulecontroller_sendcertificateAction_message_after'),
            $num > 0 ? ContextualFeedbackSeverity::OK : ContextualFeedbackSeverity::WARNING,
            true
        );
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();

        $messageQueue->addMessage($message);

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $pageUid = $id ?? 0;
        $uri = (string)$uriBuilder->buildUriFromRoute('tx_sfeventmgt.Administration_list', ['id' => $pageUid]);

        return $this->responseFactory->createResponse()->withHeader('Location', $uri);
    }

    /**
     * Preview a certificate PDF for the given event.
     *
     * @param int $event
     * @return ResponseInterface
     */
    public function previewcertificateAction(int $event): ResponseInterface
    {
        $event = $this->eventRepository->findByUidIncludeHidden($event ?? 0);
        $registration = new Registration();
        $registration->setFirstname($this->getLanguageService()->sL(self::LANG_FILE . 'eventextensionmodulecontroller_previewcertificateAction_firstname'));
        $registration->setLastname($this->getLanguageService()->sL(self::LANG_FILE . 'eventextensionmodulecontroller_previewcertificateAction_lastname'));
        $registration->setDateOfBirth(new DateTime($this->getLanguageService()->sL(self::LANG_FILE . 'eventextensionmodulecontroller_previewcertificateAction_dateofbirth')));

        $html = $this->renderTeilnahmeHtml($event, $registration);
        $dompdf = $this->getTeilnahmeDomPdf($html);

        $streamFactory = GeneralUtility::makeInstance(StreamFactoryInterface::class);

        return $this->responseFactory->createResponse()
            ->withHeader('Cache-Control', 'must-revalidate')
            ->withHeader('Content-Type', 'application/pdf')
            ->withStatus(200)
            ->withBody($streamFactory->createStream($dompdf->output()));
    }

    /**
     * Get the global language service instance.
     *
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Send a meeting link email for a registration.
     *
     * @param Registration $registration
     * @param Event $event
     * @param Address $from
     * @param array $settings
     * @return void
     */
    private function sendMeetingLinkMail(Registration $registration, Event $event, Address $from, array $settings): void
    {
        if (($settings['meeting']['subject'] ?? '') === '') {
            return;
        }
        $email = GeneralUtility::makeInstance(FluidEmail::class);
        $email
            ->to($registration->getEmail())
            ->from($from)
            ->subject($this->fluidRenderingService->parseString($this->request, $settings['meeting']['subject'], ['event' => $event]))
            ->format(FluidEmail::FORMAT_BOTH)
            ->setTemplate('EventTeamsLink')
            ->setRequest($this->request)
            ->assignMultiple([
                'event' => $event,
                'registration' => $registration,
            ]);
        GeneralUtility::makeInstance(Mailer::class)->send($email);
    }

    /**
     * Send a certificate email with PDF attachment for a registration.
     *
     * @param Registration $registration
     * @param Event $event
     * @param Dompdf $dompdf
     * @param Address $from
     * @param array $settings
     * @return void
     */
    private function sendCertificateMail(Registration $registration, Event $event, Dompdf $dompdf, Address $from, array $settings): void
    {
        if (($settings['certificate']['subject'] ?? '') === '') {
            return;
        }
        $email = GeneralUtility::makeInstance(FluidEmail::class);
        $email
            ->to($registration->getEmail())
            ->from($from)
            ->subject($this->fluidRenderingService->parseString($this->request, $settings['certificate']['subject'], ['event' => $event]))
            ->format(FluidEmail::FORMAT_BOTH)
            ->setTemplate('EventCertificate')
            ->setRequest($this->request)
            ->assignMultiple([
                'event' => $event,
            ])
            ->attach($dompdf->output(), $this->getLanguageService()->sL(self::LANG_FILE . 'eventextensionmodulecontroller_sendCertificateMail_attachmentname'), 'application/pdf');
        GeneralUtility::makeInstance(Mailer::class)->send($email);
    }

    /**
     * Render the HTML for the certificate template.
     *
     * @param Event $event
     * @param Registration $registration
     * @return string
     */
    private function renderTeilnahmeHtml(Event $event, Registration $registration): string
    {
        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
        $standaloneView->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName($this->settings['certificate']['templatePath']));
        $standaloneView->assignMultiple([
            'event' => $event,
            'registration' => $registration,
            'stampImagePath' => $this->settings['certificate']['stampImagePath'],
        ]);

        unset ($GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['processors']['DeferredBackendImageProcessor']);
        return $standaloneView->render();
    }

    /**
     * Build a Dompdf instance from HTML for the certificate.
     *
     * @param string $html
     * @return Dompdf
     */
    private function getTeilnahmeDomPdf(string $html): Dompdf
    {
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf;
    }

    /**
     * Retrieve records for the backend record list controller.
     *
     * @param mixed $request
     * @param string $table
     * @param int $id
     * @return mixed
     */
    private function getRecords($request, $table, $id)
    {
        $recordListController = GeneralUtility::makeInstance(RecordListController::class);

        $backendModuleRequest = new ReflectionObject($request);
        $requestProperty = $backendModuleRequest->getProperty('request');
        $requestProperty->setAccessible(true);
        $request = $requestProperty->getValue($request);

        $serverRequest = new ReflectionObject($request);
        $queryParamsProperty = $serverRequest->getProperty('queryParams');
        $queryParamsProperty->setAccessible(true);
        $queryParams = $queryParamsProperty->getValue($request);

        $queryParams['table'] = $table;
        $queryParams['id'] = $id;

        $queryParamsProperty->setValue($request, $queryParams);
        $newRequest = GeneralUtility::makeInstance(Request::class, $request);
        return $recordListController->mainAction($newRequest);
    }
}
