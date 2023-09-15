<?php declare(strict_types=1);

namespace Traveler\Presentation\Controllers;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Traveler\Infrastructure\Models\City\City;
use Traveler\Infrastructure\Models\City\CityQuery;
use Traveler\Infrastructure\Models\Sight\SightQuery;
use Traveler\Infrastructure\Models\Traveler\TravelerQuery;
use Traveler\Presentation\Transformers\CityTransformer;
use Traveler\Presentation\Transformers\SightTransformer;
use Traveler\Presentation\Transformers\TravelerTransformer;

class CityController extends RestController
{
    public function __construct(Request $request,
                                protected Manager $fractal,
                                protected CityTransformer $cityTransformer,
                                protected TravelerTransformer $travelerTransformer,
                                protected SightTransformer $sightTransformer
    )
    {
        parent::__construct($request);
    }


    public function index(): JsonResponse
    {

        $res = CityQuery::create()->find();

        $cities = new Collection($res, $this->cityTransformer);
        $cities = $this->fractal->createData($cities);

        return new JsonResponse($cities->toArray());
    }

    public function show(array $args): JsonResponse
    {
        $id = $args['id'] ?? null;

        if ($id) {
            $res = CityQuery::create()->findOneById($id);
        }

        if (!$res) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $cities = new Item($res, $this->cityTransformer);
        $cities = $this->fractal->createData($cities);

        return new JsonResponse($cities->toArray());
    }

    public function showSights(array $args): JsonResponse
    {
        $id = $args['id'] ?? null;

        if ($id) {
            $res = CityQuery::create()->findOneById($id);
        }

        if (!$res) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $items = SightQuery::create()->filterBycityId($id)->find();


        $items = new Collection($items, $this->sightTransformer);
        $items = $this->fractal->createData($items);

        return new JsonResponse($items->toArray());
    }

    public function showTravelers(array $args): JsonResponse
    {
        $id = $args['id'] ?? null;

        if ($id) {
            $res = CityQuery::create()->findOneById($id);
        }

        if (!$res) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $items = TravelerQuery::create()
            ->useTravelersCitiesRelQuery()
            ->filterByCityId($id)
            ->endUse()
            ->find();

        $items = new Collection($items, $this->travelerTransformer);
        $items = $this->fractal->createData($items);

        return new JsonResponse($items->toArray());
    }


    public function delete(array $args): JsonResponse
    {
        $id = $args['id'] ?? null;

        if ($id) {
            $res = CityQuery::create()->findOneById($id);
        }

        if (!$res) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $res->delete();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function store(): JsonResponse
    {
        $data = json_decode($this->request->getContent(), true);

        $city = (new City())->fromArray($data,TableMap::TYPE_FIELDNAME);
        $city->save();

        return new JsonResponse([
            'sourceId' => $city->getId()
        ], Response::HTTP_CREATED);
    }

    public function update(array $args): JsonResponse
    {
        $data = json_decode($this->request->getContent(), true);
        $id = $args['id'] ?? null;

        if ($id) {
            $city = CityQuery::create()->findOneById($id);
        }

        $city = $city->fromArray($data,TableMap::TYPE_FIELDNAME);
        try{
            $city->save();
        }
        catch (PropelException $ex){
            return new JsonResponse(null, Response::HTTP_BAD_GATEWAY);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}