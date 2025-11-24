<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\EventListener;

use DERHANSEN\SfEventMgt\Event\ModifyRegistrationValidatorResultEvent;
use TYPO3\CMS\Extbase\Error\Error;
use TYPO3\CMS\Core\Localization\LanguageService;

final class RegistrationValidationListener
{
    /**
     * Class RegistrationValidationListener
     *
     * Event listener that validates registration data for certificate-related
     * requirements and adds appropriate validation errors.
     */

    private const LANG_FILE = 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang.xlf:';

    /**
     * Conditionally validate registration fields required for certificate issuance.
     *
     * @param ModifyRegistrationValidatorResultEvent $event
     * @return void
     */
    public function __invoke(ModifyRegistrationValidatorResultEvent $event): void
    {
        $registration = $event->getRegistration();
        $result = $event->getResult();

        if ($registration->getCertificate() === 1) {
            if (!$registration->getKammer()) {
                $result->forProperty('kammer')->addError(new Error($this->getLanguageService()->sL(self::LANG_FILE . 'registrationValidationlistener_error_1724854396'), 1724854396));
            }
            if (!$registration->getEfnnummer()) {
                $result->forProperty('efnnummer')->addError(new Error($this->getLanguageService()->sL(self::LANG_FILE . 'registrationValidationlistener_error_1724854397'), 1724854397));
            }
            if (!$registration->getDateOfBirth()) {
                $result->forProperty('dateOfBirth')->addError(new Error($this->getLanguageService()->sL(self::LANG_FILE . 'registrationValidationlistener_error_1724854395'), 1724854395));
            }
        }

        if ($registration->getCertificate() === 2) {
            if (!$registration->getDateOfBirth()) {
                $result->forProperty('dateOfBirth')->addError(new Error($this->getLanguageService()->sL(self::LANG_FILE . 'registrationValidationlistener_error_1724854395'), 1724854395));
            }
        }
    }

    /**
     * Get the language service.
     *
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
