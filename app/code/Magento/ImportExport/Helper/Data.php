<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Magento\ImportExport\Helper;

/**
 * ImportExport data helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**#@+
     * XML path for config data
     */
    const XML_PATH_EXPORT_LOCAL_VALID_PATH = 'general/file/importexport_local_valid_paths';

    const XML_PATH_BUNCH_SIZE = 'general/file/bunch_size';

    /**#@-*/

    /**
     * @var \Magento\Framework\File\Size
     */
    protected $_fileSize;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\File\Size $fileSize
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\File\Size $fileSize
    ) {
        $this->_fileSize = $fileSize;
        parent::__construct(
            $context
        );
    }

    /**
     * Get maximum upload size message
     *
     * @return string
     */
    public function getMaxUploadSizeMessage()
    {
        $maxImageSize = $this->_fileSize->getMaxFileSizeInMb();
        if ($maxImageSize) {
            $message = __('The total size of the uploadable files can\'t be more than %1M', $maxImageSize);
        } else {
            $message = __('System doesn\'t allow to get file upload settings');
        }
        return $message;
    }

    /**
     * Get valid path masks to files for importing/exporting
     *
     * @return string[]
     */
    public function getLocalValidPaths()
    {
        $paths = $this->scopeConfig->getValue(self::XML_PATH_EXPORT_LOCAL_VALID_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $paths;
    }

    /**
     * Retrieve size of bunch (how many entities should be involved in one import iteration)
     *
     * @return int
     */
    public function getBunchSize()
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_BUNCH_SIZE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
