<?php

return [
    ['GET', '[/{more:.*}]', [\Traveler\Presentation\Controllers\HomeController::class, 'index']]
];