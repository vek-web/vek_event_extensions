<?php

use Vek\EventExtensions\Controller\EventExtensionsModuleController;

return [
    'vek_event_extensions' => [
        'parent' => 'web',
        'position' => ['after' => 'web_info'],
        'access' => 'user,group',
        'workspaces' => 'live',
        'path' => '/module/web/vekEventExtensions',
        'routes' => [
            '_default' => [
                'target' => EventExtensionsModuleController::class . '::index',
            ],
            'sendlink' => [
                'target' => EventExtensionsModuleController::class . '::sendlink',
            ],
            'sendcertificate' => [
                'target' => EventExtensionsModuleController::class . '::sendcertificate',
            ],
            'previewcertificate' => [
                'target' => EventExtensionsModuleController::class . '::previewcertificate',
            ]
        ],
        'labels' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/Module/locallang_mod.xlf',
        'extensionName' => 'VekEventExtensions',
        'iconIdentifier' => 'vek_eventextensions-icon-module',
        'controllerActions' => [
            EventExtensionsModuleController::class => [
                'index',
                'sendlink',
                'sendcertificate',
                'previewcertificate',
            ],
        ],
    ],
];
