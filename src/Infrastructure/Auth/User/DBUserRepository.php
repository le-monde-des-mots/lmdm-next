<?php

namespace LmdmNext\Infrastructure\Auth\User;

use LmdmNext\Domain\Auth\User\UserRepositoryInterface;

class DBUserRepository implements UserRepositoryInterface
{

    public function checkPasswordCredentials(string $username, string $password): bool
    {
        return true;
    }
}