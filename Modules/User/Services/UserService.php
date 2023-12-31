<?php

namespace Modules\User\Services;

use Modules\User\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createUser($data)
    {
        return $this->userRepository->create($data);
    }

    public function getById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function updateUser($data, $id)
    {
        return $this->userRepository->update($data, $id);
    }

    public function updatePasswordUser($data, $id)
    {
        return $this->userRepository->updatePassword($data, $id);
    }

    //client
    public function updateProfile()
    {
        return $this->userRepository->updateProfile();
    }

    public function updateProfilePhone()
    {
        return $this->userRepository->updateProfilePhone();
    }

    public function updateProfileEmail()
    {
        return $this->userRepository->updateProfileEmail();
    }

    public function updateProfilePassword()
    {
        return $this->userRepository->updateProfilePassword();
    }
}
