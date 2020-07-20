<?php

namespace Drielen\RecentlyViewed\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Configuration extends AbstractHelper
{
    /**
     * Configuration XML paths
     */
    const XML_MODULE_ENABLED = 'drielen_recently_viewed/general/enabled';

    /**
     * Returns if module is enabled in the configuration
     * section.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->getValue(
            self::XML_MODULE_ENABLED,
            ScopeInterface::SCOPE_STORES
        );
    }
}
