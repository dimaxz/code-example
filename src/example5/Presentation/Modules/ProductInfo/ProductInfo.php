<?php


namespace Demo5\Presentation\Modules\ProductInfo;


use Demo5\Application\Catalog\CatalogService;

class ProductInfo extends AbstractModule
{
    /**
     * @var ProductInfoParams
     */
    protected $params;

    /**
     * @var CatalogService
     */
    protected $catalogService;

    /**
     * ProductInfo constructor.
     * @param CatalogService $catalogService
     */
    public function __construct(CatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    /**
     * @return string
     */
    public function procces(): string
    {

        $product = $this->catalogService->getProductById($this->params->getProductId());

        return $this->render([
            'product' => $product
        ]);
    }
}