<?php

namespace Traveler\Presentation\Controllers;

class HomeController extends BaseController
{

    public function index(){

        return $this->render('home');
    }

}