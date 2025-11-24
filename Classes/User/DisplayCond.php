<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\User;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;

class DisplayCond
{
    /**
     * Class DisplayCond
     *
     * Provides custom TCA display condition helpers for the extension.
     */

    /**
     * Determine if certificate-related fields should be shown for a record.
     *
     * @param array $data
     * @param callable $evaluateDisplayConditions
     * @return bool
     */
    public function showCertificateFields($data, $evaluateDisplayConditions): bool
    {
        if (isset($data['record']['event']) && (int)$data['record']['event'] > 0) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_sfeventmgt_domain_model_event');
            $result = $queryBuilder
                ->select('eventtype')
                ->from('tx_sfeventmgt_domain_model_event')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int)$data['record']['event'], Connection::PARAM_INT))
                )
                ->executeQuery()
                ->fetchOne();

            if ($result === 1) {
                return true;
            }
        }
        return false;
    }
}
