<?php declare(strict_types=1);

use Traveler\Presentation\Controllers\CityController;
use Traveler\Presentation\Controllers\TravelerController;
use Traveler\Presentation\Controllers\HomeController;
use Traveler\Presentation\Controllers\SightController;

return [
    [['GET'], '/api/v1/cities', [CityController::class, 'index']],
    [['POST'], '/api/v1/cities', [CityController::class, 'store']],
    [['PUT'], '/api/v1/cities/{id:\d+}', [CityController::class, 'update']],
    [['GET'], '/api/v1/cities/{id:\d+}', [CityController::class, 'show']],
    [['GET'], '/api/v1/cities/{id:\d+}/sights', [CityController::class, 'showSights']],
    [['GET'], '/api/v1/cities/{id:\d+}/travelers', [CityController::class, 'showTravelers']],
    [['DELETE'], '/api/v1/cities/{id:\d+}', [CityController::class, 'delete']],

    [['GET'], '/api/v1/sights', [SightController::class, 'index']],
    [['POST'], '/api/v1/sights', [SightController::class, 'store']],
    [['PUT'], '/api/v1/sights/{id:\d+}', [SightController::class, 'update']],
    [['GET'], '/api/v1/sights/{id:\d+}', [SightController::class, 'show']],
    [['DELETE'], '/api/v1/sights/{id:\d+}', [SightController::class, 'delete']],

    [['GET'], '/api/v1/travelers', [TravelerController::class, 'index']],
    [['POST'], '/api/v1/travelers', [TravelerController::class, 'store']],
    [['PUT'], '/api/v1/travelers/{id:\d+}', [TravelerController::class, 'update']],
    [['GET'], '/api/v1/travelers/{id:\d+}', [TravelerController::class, 'show']],
    [['GET'], '/api/v1/travelers/{id:\d+}/cities', [TravelerController::class, 'showCities']],
    [['DELETE'], '/api/v1/travelers/{id:\d+}', [TravelerController::class, 'delete']],

    [['GET'], '/[{more:.*}]', [HomeController::class, 'index']],
];