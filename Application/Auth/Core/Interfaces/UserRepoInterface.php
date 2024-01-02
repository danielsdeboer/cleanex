<?php

namespace Application\Auth\Core\Interfaces;

use Application\Auth\Core\Entities\User;
use Application\Auth\Core\Values\UserEmail;
use Ramsey\Uuid\UuidInterface;

interface UserRepoInterface
{
	/** @throws \Application\Common\Core\Exceptions\NotFoundInRepoException */
	public function findById(UuidInterface $id): User;
	/** @throws \Application\Common\Core\Exceptions\NotFoundInRepoException */
	public function findByEmail(UserEmail $email): User;
	public function isEmailAlreadyInUse(UserEmail $email): bool;
	public function insert(User $user): User;
	public function updateRememberToken(User $user);
}
