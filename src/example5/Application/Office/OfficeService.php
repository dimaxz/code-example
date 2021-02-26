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
    protected $authDriver;

    /**
     * OfficeService constructor.
     * @param UserRepository $userRepository
     * @param Auth $authDriver
     */
    public function __construct(UserRepository $userRepository, Auth $authDriver)
    {
        $this->userRepository = $userRepository;
        $this->authDriver = $authDriver;
    }

    /**
     * @param int $id
     * @return UserEntity|null
     */
    public function getUserById(int $id): ?UserEntity
    {
        if (!$user = $this->userRepository->findById($id)){
            throw new UserNotFound('user not found by id ' . $id);
        }

        return $user;
    }

    /**
     * @return UserEntity|null
     */
    public function getCurrentUser(): ?UserEntity
    {
        $data = $this->authDriver->getAuthUser();

        if (!$user = $this->userRepository->findById($data['user_id'])){
            throw new UserNotFound('current user not found');
        }

        return $user;
    }
}