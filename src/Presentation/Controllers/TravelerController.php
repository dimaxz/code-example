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
use Traveler\Infrastructure\Models\Traveler\Traveler;
use Traveler\Infrastructure\Models\Traveler\TravelerQuery;
use Traveler\Presentation\Transformers\TravelerTransformer;

class TravelerController extends RestController
{
    public function __construct(Request $request,
                                protected Manager $fractal,
                                protected TravelerTransformer $transformer)
    {
        parent::__construct($request);
    }


    public function index(): JsonResponse
    {

        $res = TravelerQuery::create()->find();

        $items = new Collection($res, $this->transformer);
        $items = $this->fractal->createData($items);

        return new JsonResponse($items->toArray());
    }

    public function show(array $args): JsonResponse
    {
        $id = $args['id'] ?? null;

        if ($id) {
            $res = TravelerQuery::create()->findOneById($id);
        }

        if (!$res) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $items = new Item($res, $this->transformer);
        $items = $this->fractal->createData($items);

        return new JsonResponse($items->toArray());
    }

    public function delete(array $args): JsonResponse
    {
        $id = $args['id'] ?? null;

        if ($id) {
            $item = TravelerQuery::create()->findOneById($id);
        }

        if (!$item) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $item->delete();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function store(): JsonResponse
    {
        $data = json_decode($this->request->getContent(), true);

        $item = (new Traveler())->fromArray($data,TableMap::TYPE_FIELDNAME);

        try{
            $item->save();
        }
        catch (PropelException $ex){
            return new JsonResponse(null, Response::HTTP_BAD_GATEWAY);
        }


        return new JsonResponse([
            'sourceId' => $item->getId()
        ], Response::HTTP_CREATED);
    }

    public function update(array $args): JsonResponse
    {
        $data = json_decode($this->request->getContent(), true);
        $id = $args['id'] ?? null;

        if ($id) {
            $item = TravelerQuery::create()->findOneById($id);
        }

        $item = $item->fromArray($data,TableMap::TYPE_FIELDNAME);

        try{
            $item->save();
        }
        catch (PropelException $ex){
            return new JsonResponse(null, Response::HTTP_BAD_GATEWAY);
        }


        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}