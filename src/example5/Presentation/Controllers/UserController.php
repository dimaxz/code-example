<?php


namespace Demo5\Presentation\Controllers;

use Demo5\Application\Office\OfficeService;
use Demo5\Domain\User\Exceptions\UserNotFoundException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use spaceonfire\CommandBus\CommandBus;

class UserController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected $officeService;
    protected $commandBus;

    /**
     * UserController constructor.
     * @param OfficeService $officeService
     * @param CommandBus $commandBus
     */
    public function __construct(OfficeService $officeService, CommandBus $commandBus)
    {
        $this->officeService = $officeService;
        $this->commandBus = $commandBus;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {

        try{
            $user = $this->officeService->getUserById($id);
        }catch (UserNotFoundException $ex){
            return new JsonResponse([], 404);
        }

        return new JsonResponse([
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ], 200);
    }

    /**
     * Реализация создания пользоватя через commandBus
     * @param array $args
     * @return JsonResponse
     */
    public function create1(array $args): JsonResponse
    {

        $command = (new RegistrationUserCommand())->setEmail($args['email'])->setName($args['name']);

        try {
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


    /**
     * Реализация создания пользоватя через сервис-фасад + Command
     * @param array $args
     * @return JsonResponse
     */
    public function create2(array $args): JsonResponse
    {

        try {

            $id = $this->officeService->registerUser(
                (new RegistrationUserCommand())
                    ->setEmail($args['email'])
                    ->setName($args['name'])
            );

        } catch (RegistrationUserException $ex) {
            return new JsonResponse([
                'error' => 'not create user'
            ], 500);
        }

        return new JsonResponse([
            'sourceId' => $id,
        ], 200);
    }

    /**
     * Реализация создания пользоватя через объект-агрегат
     * @param array $args
     * @return JsonResponse
     */
    public function create3(array $args): JsonResponse
    {

        $office = $this->officeService->getCurrentOffice();

        try {

            $id = $office->registerUser($args['email'], $args['name']);

        } catch (RegistrationUserException $ex) {
            return new JsonResponse([
                'error' => 'not create user'
            ], 500);
        }

        return new JsonResponse([
            'sourceId' => $id,
        ], 200);
    }

    /**
     * Реализация создания пользоватя через сервис-фасад
     * @param array $args
     * @return JsonResponse
     */
    public function create4(array $args): JsonResponse
    {

        try {

            $id = $this->officeService->registerUser($args['email'], $args['name']);

        } catch (RegistrationUserException $ex) {
            return new JsonResponse([
                'error' => 'not create user'
            ], 500);
        }

        return new JsonResponse([
            'sourceId' => $id,
        ], 200);
    }

    /**
     * Реализация создания пользоватя через сервис-фасад + DTO
     * @param array $args
     * @return JsonResponse
     */
    public function create5(array $args): JsonResponse
    {

        try {

            $id = $this->officeService->registerUser(new UserRequest($args['email'], $args['name']));

        } catch (RegistrationUserException $ex) {
            return new JsonResponse([
                'error' => 'not create user'
            ], 500);
        }

        return new JsonResponse([
            'sourceId' => $id,
        ], 200);
    }


}