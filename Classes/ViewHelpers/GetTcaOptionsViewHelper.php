<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class GetTcaOptionsViewHelper extends AbstractViewHelper
{
    /**
     * Class GetTcaOptionsViewHelper
     *
     * ViewHelper to fetch TCA select field options and return them as an
     * associative array (value => label).
     */

    /**
     * {@inheritDoc}
     */
    public function initializeArguments()
    {
        $this->registerArgument('table', 'string', 'Table name', true);
        $this->registerArgument('field', 'string', 'Field name', true);
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $selectOptions = array();
        $data = $GLOBALS['TCA'][$this->arguments['table']]['columns'][$this->arguments['field']]['config']['items'];

        if (!is_array($data)) {
            throw new Exception('Table or field does not exists or is not a select field!', 1623678361);
        }

        foreach ($data as $row) {
            $selectOptions[$row['value']] = LocalizationUtility::translate($row['label']);
        }

        return $selectOptions;
    }
}
