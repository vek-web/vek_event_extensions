<?php
defined('TYPO3') or die();

call_user_func(
    function () {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\DERHANSEN\SfEventMgt\Domain\Model\Registration::class] = [
            'className' => \Vek\EventExtensions\Domain\Model\Registration::class
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\DERHANSEN\SfEventMgt\Domain\Model\Event::class] = [
            'className' => \Vek\EventExtensions\Domain\Model\Event::class
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\DERHANSEN\SfEventMgt\Domain\Repository\EventRepository::class] = [
            'className' => \Vek\EventExtensions\Domain\Repository\EventRepository::class
        ];
    }
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['vek'] = ['Vek\\EventExtensions\\ViewHelpers'];

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'][100] = 'EXT:vek_event_extensions/Resources/Private/Templates/Email';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['layoutRootPaths'][100] = 'EXT:vek_event_extensions/Resources/Private/Layouts/Email';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['partialRootPaths'][100] = 'EXT:vek_event_extensions/Resources/Private/Partials/Email';
