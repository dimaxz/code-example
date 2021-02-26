<?php


namespace Demo6\Domain\Stock;


use Demo6\Domain\Stock\Exceptions\UserNotFoundException;
use Demo6\Domain\Stock\User\Contracts\UserRepositoryInterface;
use Demo6\Domain\Stock\User\UserEntity;

class StockService
{
    protected $userRepository;

    /**
     * StockService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userId
     * @return UserEntity
     */
    public function getUserById(int $userId): UserEntity
    {

        if (!$user = $this->userRepository->findById($userId)) {
            throw new UserNotFoundException('user not found by id ' . $userId);
        }
        return $user;
    }

}