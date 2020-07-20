<?php

namespace Drielen\RecentlyViewed\Block;

use Drielen\RecentlyViewed\Helper\Configuration as ConfigurationHelper;
use Drielen\RecentlyViewed\Service\RecentManager;
use Magento\Framework\View\Element\Template;

class RecentlyViewedTab extends Template
{
    /**
     * @var ConfigurationHelper
     */
    private $configurationHelper;

    /**
     * RecentlyViewedTab constructor.
     *
     * @param Template\Context    $context
     * @param ConfigurationHelper $configurationHelper
     * @param array               $data
     */
    public function __construct(
        Template\Context $context,
        ConfigurationHelper $configurationHelper,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $data
        );

        $this->configurationHelper = $configurationHelper;
    }

    /**
     * Return if block is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->configurationHelper->isEnabled();
    }
}
