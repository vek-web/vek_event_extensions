<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Mail\Mailer;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Vek\EventExtensions\Utility\EmailAddressUtility;
use Vek\EventExtensions\Domain\Model\Event;
use Vek\EventExtensions\Domain\Repository\EventRepository;
use Vek\EventExtensions\Domain\Model\Registration;
use DERHANSEN\SfEventMgt\Domain\Repository\RegistrationRepository;
use DERHANSEN\SfEventMgt\Service\FluidStandaloneService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Symfony\Component\Mime\Address;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

#[AsCommand(
    name: 'vekeventextensions:event-reminder',
    description: 'Command to send event reminders',
)]
/**
 * Class EventReminderCommand
 *
 * CLI command that sends scheduled event reminders to confirmed registrations.
 */
class EventReminderCommand extends Command
{
    /**
     * EventReminderCommand constructor.
     *
     * @param EventRepository $eventRepository
     * @param RegistrationRepository $registrationRepository
     * @param PersistenceManager $persistenceManager
     * @param FluidStandaloneService $fluidStandaloneService
     */
    public function __construct(
        private readonly EventRepository        $eventRepository,
        private readonly RegistrationRepository $registrationRepository,
        private readonly PersistenceManager     $persistenceManager,
        private readonly FluidStandaloneService $fluidStandaloneService,
    )
    {
        parent::__construct();
    }

    /** {@inheritDoc} */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $settings = $configurationManager->getConfiguration(
            ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
            'VekEventExtensions'
        );

        $from = EmailAddressUtility::getSenderAddress('reminder', $settings);

        $events = $this->eventRepository->findForReminder();
        foreach ($events as $event) {
            foreach ($event->getRegistrations() as $registration) {
                if ($registration->getConfirmed() && !$registration->getReminded()) {
                    $this->sendReminder($registration, $event, $from, $settings);
                    $registration->setReminded(true);
                    $this->registrationRepository->update($registration);
                }

            }
            $this->persistenceManager->persistAll();
        }
        return Command::SUCCESS;
    }

    /**
     * Send a reminder email for a single registration.
     *
     * @param Registration $registration
     * @param Event $event
     * @param Address $from
     * @param array $settings
     * @return void
     */
    private function sendReminder(Registration $registration, Event $event, Address $from, array $settings): void
    {
        if (($settings['reminder']['subject'] ?? '') === '') {
            return;
        }

        if($event->getReminderMail()){
            try {
                $from = new Address($event->getReminderMail(), $event->getReminderMailName());
            } catch (\Exception $e) {
                return;
            }
        }

        $email = GeneralUtility::makeInstance(FluidEmail::class);
        $email
            ->to($registration->getEmail())
            ->from($from)
            ->subject($this->fluidStandaloneService->parseStringFluid($settings['reminder']['subject'], ['event' => $event]))
            ->format(FluidEmail::FORMAT_BOTH)
            ->setTemplate('EventReminder')
            ->assignMultiple([
                'event' => $event,
                'registration' => $registration,
            ]);
        GeneralUtility::makeInstance(Mailer::class)->send($email);
    }
}
