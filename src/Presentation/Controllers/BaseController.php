<?php

namespace Traveler\Presentation\Controllers;

use Twig\Environment;

abstract class BaseController
{


    public function __construct(protected Environment $twig)
    {
    }

    protected function render(string $view, array $data = []){

        return $this->twig->render($view, $data);
    }
}