<?php declare(strict_types=1);

use Traveler\Presentation\Controllers\CityController;
use Traveler\Presentation\Controllers\TravelerController;
use Traveler\Presentation\Controllers\HomeController;
use Traveler\Presentation\Controllers\SightController;

return [
    [['GET','POST'], '/form[{more:.*}]', [\Test\Presentation\Controllers\FormController::class, 'show']],
];