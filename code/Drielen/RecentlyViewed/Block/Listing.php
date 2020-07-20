<?php

namespace Drielen\RecentlyViewed\Block;

use Drielen\RecentlyViewed\Controller\Ajax\RecentListing;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;

class Listing extends Template
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * Listing constructor.
     *
     * @param Template\Context $context
     * @param RequestInterface $request
     * @param array            $data
     */
    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $data
        );

        $this->request = $request;
    }

    /**
     * Returns url that can retrieve product listing
     *
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->_urlBuilder->getUrl(RecentListing::ACTION_NAME);
    }

    /**
     * @return int
     */
    public function getCurrentProductId(): int
    {
        return (int) $this->request->getParam('id');
    }
}
