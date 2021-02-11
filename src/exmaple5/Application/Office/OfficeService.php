<?php


namespace Demo5\Application\Office;


use Demo5\Domain\User\UserEntity;
use Demo5\Infrastructure\Repositories\User\UserRepository;

class OfficeService
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * OfficeService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     * @return UserEntity|null
     */
    public function getUserById(int $id): ?UserEntity
    {
        return $this->userRepository->findById($id);
    }

    /**
     * @return UserEntity|null
     */
    public function getCurrentUser(): ?UserEntity
    {
        return $this->userRepository->findById(1);
    }
}