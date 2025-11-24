<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Event Extensions',
    'description' => 'Extensions for derhansen/sf_event_mgt',
    'category' => 'misc',
    'version' => '1.0.0',
    'state' => 'stable',
    'author' => 'vE&K Digital',
    'author_email' => 'info@ve-k.de',
    'author_company' => 'vE&K Digital',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'sf_event_mgt' => '7.0.0-7.99.99',
            'php' => '8.1.0-8.4.99',
        ],
    ],
];
