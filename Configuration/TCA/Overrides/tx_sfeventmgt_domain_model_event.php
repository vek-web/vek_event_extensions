<?php
defined('TYPO3') or die();

$fields = [
    'eventtype' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:eventtype_label',
        'description' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:eventtype_description',
        'onChange' => 'reload',
        'config' => [
            'type' => 'select',
            'items' => [
                ['LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:eventtype_items_0', 0],
                ['LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:eventtype_items_1', 1]
            ],
            'default' => 0,
            'renderType' => 'selectSingle',
            'minitems' => 1,
            'maxitems' => 1,
        ],
    ],
    'meeting_link' => [
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:meeting_link_label',
        'config' => [
            'type' => 'link',
            'allowedTypes' => ['url'],
            'appearance' => [
                'enableBrowser' => true,
            ],
        ]
    ],
    'meeting_id' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:meeting_id_label',
        'config' => [
            'type' => 'input',
            'size' => 15
        ],
    ],
    'meeting_additional_id' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:meeting_additional_id_label',
        'config' => [
            'type' => 'input',
            'size' => 15
        ],
    ],
    'reminder' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:reminder_label',
        'onChange' => 'reload',
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
    'reminder_period' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:reminder_period_label',
        'displayCond' => 'FIELD:reminder:REQ:TRUE',
        'config' => [
            'type' => 'input',
            'size' => 4,
            'eval' => 'int',
            'default' => 24,
        ],
    ],
    'reminder_mail' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:reminder_mail_label',
        'displayCond' => 'FIELD:reminder:=:1',
        'config' => [
            'type' => 'input',
            'size' => 15
        ],
    ],
    'reminder_mail_name' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:reminder_mail_name_label',
        'displayCond' => 'FIELD:reminder:=:1',
        'config' => [
            'type' => 'input',
            'size' => 15
        ],
    ],
    'vnr' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:vnr_label',
        'displayCond' => 'FIELD:eventtype:=:1',
        'config' => [
            'type' => 'input',
            'size' => 20
        ],
    ],
    'certificate_host' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_host_label',
        'displayCond' => 'FIELD:eventtype:=:1',
        'config' => [
            'type' => 'input',
            'size' => 30
        ],
    ],
    'certificate_supervisor' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_supervisor_label',
        'displayCond' => 'FIELD:eventtype:=:1',
        'config' => [
            'type' => 'input',
            'size' => 30
        ],
    ],
    'certificate_text' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_text_label',
        'displayCond' => 'FIELD:eventtype:=:1',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
            'cols' => 40,
            'rows' => 15,
            'eval' => 'trim',
        ],
    ],
    'certificate_event_location' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_event_location_label',
        'displayCond' => 'FIELD:eventtype:=:1',
        'config' => [
            'type' => 'input',
            'size' => 30
        ],
    ],
    'certificate_location' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_location_label',
        'displayCond' => 'FIELD:eventtype:=:1',
        'config' => [
            'type' => 'input',
            'size' => 30
        ],
    ],
    'certificate_date' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificate_date_label',
        'displayCond' => 'FIELD:eventtype:=:1',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'size' => 13,
            'eval' => 'datetime,int',
            'default' => 0,
        ],
    ],
    'fb_punkte' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:fb_punkte_label',
        'displayCond' => 'FIELD:eventtype:=:1',
        'config' => [
            'type' => 'input',
            'size' => 4,
            'eval' => 'int',
        ],
    ],
    'certificateimage' => [
        'exclude' => true,
        'label' => 'LLL:EXT:vek_event_extensions/Resources/Private/Language/locallang_db.xlf:certificateimage_label',
        'displayCond' => 'FIELD:eventtype:=:1',
        'config' => [
            'type' => 'file',
            'maxitems' => 1,
            'allowed' => 'common-image-types'
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_sfeventmgt_domain_model_event', $fields);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_sfeventmgt_domain_model_event',
    'eventtype,reminder,reminder_period,reminder_mail,reminder_mail_name',
    '',
    'after:top_event'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_sfeventmgt_domain_model_event',
    'meeting_link,meeting_id,meeting_additional_id',
    '',
    'after:link'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_sfeventmgt_domain_model_event',
    '--div--;Certificate of Attendance,vnr,certificate_host,certificate_supervisor,certificate_text,certificate_event_location,certificate_location,certificate_date,fb_punkte,certificateimage',
    '',
    ''
);
