<?php

namespace Drielen\RecentlyViewed\Controller\Ajax;

use Drielen\RecentlyViewed\Service\RecentManagerInterface;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class RecentListing extends Action
{

    /**
     * Full action name
     */
    const ACTION_NAME = 'recentlyviewed/ajax/recentlisting';

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var RecentManagerInterface
     */
    private $recentManager;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var RedirectFactory
     */
    private $redirectFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * RecentListing constructor.
     *
     * @param Context                  $context
     * @param PageFactory              $pageFactory
     * @param RecentManagerInterface   $recentManager
     * @param ProductCollectionFactory $productCollectionFactory
     * @param RedirectFactory          $redirectFactory
     * @param RequestInterface         $request
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        RecentManagerInterface $recentManager,
        ProductCollectionFactory $productCollectionFactory,
        RedirectFactory $redirectFactory,
        RequestInterface $request
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->recentManager = $recentManager;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->redirectFactory = $redirectFactory;
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            return $this->resultRedirectFactory->create()->setPath('');
        }

        $productId = $this->getRequest()->getParam('product_id');
        if (!empty($productId)) {
            $this->recentManager->addProductById($productId);
        }

        /** @var Page $page */
        $page = $this->pageFactory->create();

        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addFieldToFilter('entity_id', ['in' => $this->recentManager->getProductsIds()]);
        $productCollection->setPageSize(4); // @todo Dynamic configuration option

        /** @var ListProduct $listingBlock */
        $listingBlock = $page->getLayout()->createBlock(
            ListProduct::class,
            'recently_viewed_listing'
        );

        $listingBlock->setTemplate('Magento_Catalog::product/list.phtml');
        $listingBlock->setCollection($productCollection->load());

        $this->getResponse()->setBody($listingBlock->toHtml());
    }
}
