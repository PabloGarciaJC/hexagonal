<?php

namespace Application\UseCase;

use Domain\Repository\ProductRepositoryInterface;

class ListProducts
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return \Domain\Entity\Product[]
     */
    public function execute(bool $onlyActive = true): array
    {
        if ($onlyActive) {
            return $this->productRepository->findActive();
        }
        return $this->productRepository->findAll();
    }
}
