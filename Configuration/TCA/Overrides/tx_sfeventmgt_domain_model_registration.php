<?php
defined('TYPO3') or die();

$fields = [
    'certificate' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_label',
        'displayCond' => 'USER:Vek\\EventExtensions\\User\\DisplayCond->showCertificateFields',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_items_0', ''],
                ['LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_items_1', 1],
                ['LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_items_2', 2],
                ['LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_items_3', 3],
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
        ],
    ],
    'kammer' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:kammer_label',
        'displayCond' => [
            'AND' => [
                'FIELD:certificate:=:1',
                'USER:Vek\\EventExtensions\\User\\DisplayCond->showCertificateFields',
            ],
        ],
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:kammer_items_0', ''],
                ['LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:kammer_items_1', 1],
                ['LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:kammer_items_2', 2],
            ],
            'size' => 1,
            'minitems' => 1,
            'maxitems' => 1,
        ],
    ],
    'efnnummer' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:efnnummer_label',
        'displayCond' => [
            'AND' => [
                'FIELD:certificate:=:1',
                'USER:Vek\\EventExtensions\\User\\DisplayCond->showCertificateFields',
            ],
        ],
        'config' => [
            'type' => 'input',
            'size' => 30
        ],
    ],
    'date_of_birth' => [
        'exclude' => true,
        'label' => 'LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgt_domain_model_registration.date_of_birth',
        'config' => [
            'type' => 'datetime',
            'format' => 'date',
            'default' => 0,
        ],
        'displayCond' => [
            'AND' => [
                'FIELD:certificate:IN:1,2',
                'USER:Vek\\EventExtensions\\User\\DisplayCond->showCertificateFields',
            ],
        ],
    ],
    'reminded' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:reminded_label',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'default' => 0,
            'items' => [
                [
                    0 => '',
                    1 => '',
                ],
            ],
        ],
    ],
    'linksent' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:linksent_label',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'default' => 0,
            'items' => [
                [
                    0 => '',
                    1 => '',
                ],
            ],
        ],
    ],
    'certificatecompliance' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificatecompliance_label',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'default' => 1,
            'items' => [
                [
                    0 => '',
                    1 => '',
                ],
            ],
        ],
        'displayCond' => [
            'AND' => [
                'FIELD:certificate:IN:1,2',
                'USER:Vek\\EventExtensions\\User\\DisplayCond->showCertificateFields',
            ],
        ],
    ],
    'certificatesent' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificatesent_label',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'default' => 1,
            'items' => [
                [
                    0 => '',
                    1 => '',
                ],
            ],
        ],
        'displayCond' => [
            'AND' => [
                'FIELD:certificate:IN:1,2',
                'USER:Vek\\EventExtensions\\User\\DisplayCond->showCertificateFields',
            ],
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_sfeventmgt_domain_model_registration', $fields);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_sfeventmgt_domain_model_registration',
    'certificate,kammer,efnnummer,dateOfBirth,certificatecompliance',
    '',
    'after:email'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_sfeventmgt_domain_model_registration',
    'reminded,linksent,certificatesent',
    '',
    'after:registration_date'
);
