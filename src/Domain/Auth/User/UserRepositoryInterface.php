<?php

namespace LmdmNext\Domain\Auth\User;

interface UserRepositoryInterface
{
    public function checkPasswordCredentials(string $username, string $password): bool;
}