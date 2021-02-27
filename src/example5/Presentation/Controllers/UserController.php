<?php


namespace Demo5\Presentation\Controllers;

use Demo5\Application\Office\OfficeService;
use Demo5\Domain\User\Exceptions\UserNotFoundException;
use Demo5\Presentation\Exceptions\ErrorException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use spaceonfire\CommandBus\CommandBus;

class UserController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected $officeService;

    /**
     * UserController constructor.
     * @param OfficeService $officeService
     */
    public function __construct(OfficeService $officeService)
    {
        $this->officeService = $officeService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {

        try {
            $user = $this->officeService->getUserById($id);
        } catch (UserNotFoundException $ex) {
            return new JsonResponse([], 404);
        }

        return new JsonResponse([
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ], 200);
    }
    

    /**
     * Реализация создания пользоватя через сервис
     * @param array $args
     * @return JsonResponse
     */
    public function create(array $args): JsonResponse
    {

        try {

            $id = $this->officeService->registerUser(
                new RegistrationUserCommand($args['email'], $args['name'])
            );

        } catch (RegistrationUserException $ex) {

            $this->logger->error($ex->getMessage());

            return new ErrorException();
        }

        return new JsonResponse([
            'sourceId' => $id,
        ], 200);
    }


}