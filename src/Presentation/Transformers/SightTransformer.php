<?php

namespace Traveler\Presentation\Transformers;

use League\Fractal\TransformerAbstract;
use Traveler\Infrastructure\Models\Sight\Sight;

class SightTransformer extends TransformerAbstract
{
    public function transform(Sight $city)
    {
        return [
            'id' => $city->getId(),
            'name' => $city->getName()
        ];
    }
}