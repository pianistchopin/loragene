<?php

namespace Drielen\RecentlyViewed\Service;

interface RecentManagerInterface
{
    /** @var string Key to save data to session */
    const SESSION_KEY = 'recently_viewed_products';

    /**
     * Returns array of product id's that have been
     * recently viewed by the customer
     *
     * @return array
     */
    public function getProductsIds(): array;

    /**
     * Adds product to recently viewed products
     *
     * @param int $productId
     *
     * @return bool Successfully added to list
     */
    public function addProductById(int $productId): bool;

    /**
     * Reset recently viewed products
     *
     * @return bool
     */
    public function reset(): bool;
}
