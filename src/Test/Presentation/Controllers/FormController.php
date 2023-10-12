<?php

namespace Test\Presentation\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Test\Aplication\Product\ProductService;
use Traveler\Presentation\Controllers\BaseController;

class FormController extends BaseController
{


    public function __construct(protected Request $request, protected ProductService $productService)
    {
    }

    public function show(){

        $post = $this->request->request->all();

        if($post){
            $this->productService->addProduct($post);
        }

        return $this->render('form');
    }

}