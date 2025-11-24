<?php

declare(strict_types=1);

return [
    \Vek\EventExtensions\Domain\Model\Event::class => [
        'tableName' => 'tx_sfeventmgt_domain_model_event',
    ],
    \Vek\EventExtensions\Domain\Model\Registration::class => [
        'tableName' => 'tx_sfeventmgt_domain_model_registration',
    ],
];
