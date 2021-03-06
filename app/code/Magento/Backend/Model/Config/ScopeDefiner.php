<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Backend\Model\Config;

use Magento\Store\Model\ScopeInterface as StoreScopeInterface;

/**
 * System configuration scope
 */
class ScopeDefiner
{
    /**
     * Request object
     *
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(\Magento\Framework\App\RequestInterface $request)
    {
        $this->_request = $request;
    }

    /**
     * Retrieve current config scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->_request->getParam(
            'store'
        ) ? StoreScopeInterface::SCOPE_STORE : ($this->_request->getParam(
            'website'
        ) ? StoreScopeInterface::SCOPE_WEBSITE : \Magento\Framework\App\ScopeInterface::SCOPE_DEFAULT);
    }
}
