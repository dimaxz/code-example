<?php


namespace Demo6\Presentation\Controllers\UserController;


use Demo6\Domain\Stock\StockService;

class UserController
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {

        $stock = $this->stockService->getStockByDomain('site.ru');

        if ($user = $stock->getUserById($id)) {
            return new JsonResponse([], 404);
        }

        return new JsonResponse([
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ], 200);
    }


    /**
     * @return JsonResponse
     */
    public function create(array $args): JsonResponse
    {

        $stock = $this->stockService->getStockByDomain('site.ru');

        $command = (new RegistrationUserCommand())->setEmail($args['email'])->setName($args['name']);

        try {
            $stock->registerUser($args['email'], $args['name']);
            $this->commandBus->handle($command);
        } catch (RegistrationUserException $ex) {
            return new JsonResponse([
                'error' => 'not create user'
            ], 500);
        }

        return new JsonResponse([
            'sourceId' => $command->getSourceId(),
        ], 200);
    }
}