<?php declare(strict_types=1);

namespace Traveler\Presentation\Controllers;

class HomeController extends BaseController
{

    public function index(){

        return $this->render('home');
    }

}