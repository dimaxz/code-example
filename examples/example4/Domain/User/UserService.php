<?php


namespace Domain\User;


use Domain\User\Contracts\UserRepositoryInterface;
use Domain\User\Exceptions\UserNotFoundException;

class UserService
{

    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     * @return UserEntity
     */
    public function getById(int $id): UserEntity
    {

        if (!$user = $this->userRepository->findById($id)) {
            throw new UserNotFoundException('user not found by id ' . $id);
        }


        return $user;
    }

    /**
     * @param User $user
     * @return int
     */
    public function create(User $user): int
    {
        $this->userRepository->save($user);
        return $user->getId();
    }

    /**
     * @param User $user
     */
    public function update(User $user): void
    {
        $this->userRepository->save($user);
    }
}