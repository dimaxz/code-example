<?php


namespace Demo4\Presentation\Controllers;


use Demo4\Application\Commands\Registration\RegistrationUser\RegistrationUserCommand;
use Demo4\Domain\User\Contracts\UserRepositoryInterface;
use Demo4\Infrastructure\JsonResponse;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use spaceonfire\CommandBus\CommandBus;

class UserController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected $userRepository;
    protected $commandBus;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param CommandBus $commandBus
     */
    public function __construct(UserRepositoryInterface $userRepository, CommandBus $commandBus)
    {
        $this->userRepository = $userRepository;
        $this->commandBus = $commandBus;
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {

        if(!$user = $this->userRepository->findById($id)){
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

        $command = (new RegistrationUserCommand())->setEmail($args['email'])->setName($args['name']);

        try{
            $this->commandBus->handle($command);
        }
        catch (RegistrationUserException $ex){
            return new JsonResponse([
                'error' => 'not create user'
            ], 500);
        }

        return new JsonResponse([
            'sourceId' => $command->getSourceId(),
        ], 200);
    }
}