<?php


namespace Demo5\Application\Office\Contracts;


use Demo5\Domain\User\UserEntity;

interface OfficeServiceInterface
{
    /**
     * @param int $id
     * @return UserEntity|null
     */
    public function getUserById(int $id): ?UserEntity;

    /**
     * @return UserEntity|null
     */
    public function getCurrentUser(): ?UserEntity;

    /**
     * @param RegistrationUserInterface $command
     * @return int
     */
    public function registerUser(RegistrationUserInterface $command): int;
}