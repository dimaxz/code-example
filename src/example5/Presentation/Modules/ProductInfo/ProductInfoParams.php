<?php


namespace Demo5\Presentation\Modules\ProductInfo;


class ProductInfoParams extends AbstractModuleParams
{

    /**
     * @var int
     */
    protected $productId;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }


}