<?php declare(strict_types=1);

namespace Traveler\Presentation\Controllers;


use Symfony\Component\HttpFoundation\Request;

abstract class RestController
{


    public function __construct(protected Request $request)
    {
    }
}