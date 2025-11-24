<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\Domain\Repository;

use DERHANSEN\SfEventMgt\Domain\Repository\EventRepository as OriginalEventRepository;

class EventRepository extends OriginalEventRepository
{
    /**
     * Class EventRepository
     *
     * Repository extension providing custom queries for events used by
     * vek_event_extensions
     */

    /**
     * Find events that require reminders to be sent.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findForReminder()
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM `tx_sfeventmgt_domain_model_event` WHERE
                                                     reminder = 1 AND
                                                     enddate > UNIX_TIMESTAMP() AND
                                                     (UNIX_TIMESTAMP() + (reminder_period * 60 * 60)) >= enddate AND
                                                     deleted = 0 AND
                                                     hidden = 0 AND
                                                     starttime <= UNIX_TIMESTAMP() AND
                                                     ((endtime = 0) OR (endtime > UNIX_TIMESTAMP()))');
        return $query->execute();
    }
}
