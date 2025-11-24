<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\EventListener\Backend;

use TYPO3\CMS\Backend\View\Event\ModifyDatabaseQueryForRecordListingEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use PDO;

final class ModifyRecordListQueryListener
{
    /**
     * Class ModifyRecordListQueryListener
     *
     * Listener that modifies the backend record listing database query to filter
     * registrations by event when the custom module route is used.
     */

    /**
     * Modify the database query for the backend record listing to filter by event.
     *
     * @param ModifyDatabaseQueryForRecordListingEvent $event
     * @return void
     */
    public function __invoke(ModifyDatabaseQueryForRecordListingEvent $event): void
    {
        $request = $GLOBALS['TYPO3_REQUEST'];
        $routePath = $request->getAttribute('route')->getPath() ?? null;
        $eventId = $request->getQueryParams()['event'] ?? null;

        if ($routePath !== '/module/web/vekEventExtensions' || $eventId === null) {
            return;
        }

        $queryBuilder = $event->getQueryBuilder();

        if ($event->getTable() === 'tx_sfeventmgt_domain_model_registration') {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('event', $queryBuilder->createNamedParameter($eventId, PDO::PARAM_INT))
            );
        }

        $event->setQueryBuilder($queryBuilder);
    }
}
