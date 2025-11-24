<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\Utility;

use Symfony\Component\Mime\Address;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class EmailAddressUtility
{
    /**
     * Class EmailAddressUtility
     *
     * Helper utility to resolve sender email addresses and names from
     * extension settings or original.
     */

    /**
     * Resolve the sender address for a given mail type from extensions settings or original.
     *
     * @param string $type
     * @param array $settings
     * @return Address|null
     */
    public static function getSenderAddress(string $type, array $settings): Address|null
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $configuration = $configurationManager->getConfiguration(
            ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
            'SfEventMgt'
        );

        $email = $settings[$type]['senderEmail'] !== '' ? $settings[$type]['senderEmail'] : $configuration['notification']['senderEmail'] ?? '';
        if ($email === '') {
            return null;
        }
        $name = $settings[$type]['senderName'] !== '' ? $settings[$type]['senderName'] : $configuration['notification']['senderName'] ?? '';

        return new Address($email, $name);
    }
}
