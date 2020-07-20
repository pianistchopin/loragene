<?php

namespace Drielen\RecentlyViewed\Service;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Session\SessionManager;
use Magento\Store\Model\StoreManagerInterface;

class RecentManager implements RecentManagerInterface
{

    /**
     * @var SessionManager
     */
    private $sessionManager;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * RecentManager constructor.
     *
     * @param SessionManager             $sessionManager
     * @param ProductRepositoryInterface $productRepository
     * @param StoreManagerInterface      $storeManager
     */
    public function __construct(
        SessionManager $sessionManager,
        ProductRepositoryInterface $productRepository,
        StoreManagerInterface $storeManager
    ) {
        $this->sessionManager = $sessionManager;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritDoc
     */
    public function getProductsIds(): array
    {
        return $this->getProductsIdsFromSession();
    }

    /**
     * @return array
     */
    public function getProductsIdsFromSession(): array
    {
        $productIds = $this->sessionManager->getData(self::SESSION_KEY) ?? [];

        if (!is_array($productIds)) {
            $productIds = [];
        }

        return $productIds;
    }

    /**
     * @inheritDoc
     */
    public function addProductById(int $productId): bool
    {
        try {
            $product = $this->productRepository->getById(
                $productId,
                false,
                $this->storeManager->getStore()->getId()
            );

            $canShow = $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility();

            if ($canShow) {
                $productIds = $this->getProductsIdsFromSession();

                if (!in_array($productId, $productIds)) {
                    $productIds[] = $productId;
                    $this->sessionManager->setData(self::SESSION_KEY, $productIds);
                }
                return true;
            }
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function reset(): bool
    {
        // TODO: Implement reset() method.
    }

    /**
     * Returns SessionManager to be used in integrations
     *
     * @return SessionManager
     */
    public function getSessionManager(): SessionManager
    {
        return $this->sessionManager;
    }
}
