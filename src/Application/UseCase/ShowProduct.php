<?php

namespace Application\UseCase;

use Domain\Repository\ProductRepositoryInterface;
use Domain\Entity\Product;

class ShowProduct
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(int $productId): ?Product
    {
        return $this->productRepository->findById($productId);
    }
}
