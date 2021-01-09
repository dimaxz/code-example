<?php


namespace Application\Controllers;


use Application\Commands\Office\CreateUser\CreateUserCommand;
use Application\Commands\Office\CreateUser\UserRequest;
use Application\Commands\Office\CreateUser\UserResult;
use Domain\User\Exceptions\UserNotFoundException;
use Domain\User\UserService;
use Infrastructure\JsonResponse;

class UserController implements LoggerAwareInterface
{
    use LoggerAwaretrait;

    protected $userService;
    protected $commandBus;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param CommandBus $commandBus
     */
    public function __construct(UserService $userService, CommandBus $commandBus)
    {
        $this->userService = $userService;
        $this->commandBus = $commandBus;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {

        try {
            $user = $this->userService->getById($id);
        } catch (UserNotFoundException $ex) {

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

        $userRequest = (new UserRequest())->setEmail($args['email'])->setName($args['name']);
        $userResult = new UserResult();

        try{
            $this->commandBus->handle(new CreateUserCommand($userRequest,$userResult));
        }
        catch (CreateUserException $ex){
            return new JsonResponse([
                'error' => 'not create user'
            ], 500);
        }

        return new JsonResponse([
            'sourceId' => $userResult->getSourceId(),
        ], 200);
    }
}