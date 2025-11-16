<?php

namespace Application\UseCase;

use Domain\Repository\ProductRepositoryInterface;

class CreateProduct
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Create a new product.
     * Returns the created product with ID assigned.
     */
    public function execute(
        string $sku,
        string $name,
        string $description,
        float $price,
        string $currency,
        int $stock,
        bool $active = true
    ): \Domain\Entity\Product {
        $product = new \Domain\Entity\Product(
            $sku,
            $name,
            $description,
            $price,
            $currency,
            $stock,
            $active
        );
        return $this->productRepository->save($product);
    }
}
