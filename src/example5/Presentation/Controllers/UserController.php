<?php


namespace Demo5\Presentation\Controllers;

use Demo5\Application\Office\OfficeService;
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

        if(!$user = $this->officeService->getUserById($id)){
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