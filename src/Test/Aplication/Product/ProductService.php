<?php

namespace Test\Aplication\Product;

use Test\Domain\Product\Product;
use Test\Infrastructure\Repositories\Product\ProductRepository;

class ProductService
{


    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function addProduct(array $data): int{

        //валидация


        $product = new Product($data['name'],$data['amount']);


        $this->productRepository->save($product);

        return $product->getId();
    }

}