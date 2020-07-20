<?php

namespace Drielen\RecentlyViewed\Observer;

use Drielen\RecentlyViewed\Service\RecentManagerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ControllerPreDispatchObserver implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var RecentManagerInterface
     */
    private $recentManager;

    /**
     * ControllerPreDispatchObserver constructor.
     *
     * @param RequestInterface       $request
     * @param RecentManagerInterface $recentManager
     */
    public function __construct(
        RequestInterface $request,
        RecentManagerInterface $recentManager
    ) {
        $this->request = $request;
        $this->recentManager = $recentManager;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $productId = (int) $this->request->getParam('id');
        $this->recentManager->addProductById($productId);
    }
}
