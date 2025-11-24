<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Event Extensions',
    'description' => 'Extensions for derhansen/sf_event_mgt',
    'category' => 'misc',
    'version' => '1.1.0',
    'state' => 'stable',
    'author' => 'vE&K Digital',
    'author_email' => 'info@ve-k.de',
    'author_company' => 'vE&K Digital',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'sf_event_mgt' => '8.0.0-8.99.99',
            'php' => '8.2.0-8.4.99',
        ],
    ],
];
