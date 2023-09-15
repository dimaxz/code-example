<?php

namespace Traveler\Presentation\Transformers;

use League\Fractal\TransformerAbstract;
use Traveler\Infrastructure\Models\City\City;

class CityTransformer extends TransformerAbstract
{
    public function transform(City $city)
    {
        return [
            'id' => $city->getId(),
            'name' => $city->getName()
        ];
    }
}