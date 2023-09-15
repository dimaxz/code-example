<?php declare(strict_types=1);

namespace Traveler\Presentation\Transformers;

use League\Fractal\TransformerAbstract;
use Traveler\Infrastructure\Models\Traveler\Traveler;

class TravelerTransformer extends TransformerAbstract
{
    public function transform(Traveler $city)
    {
        return [
            'id' => $city->getId(),
            'name' => $city->getName()
        ];
    }
}