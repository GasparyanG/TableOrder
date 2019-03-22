<?php

namespace App\Service\User\Authority\Roles\Products;

use App\Service\User\Authority\Roles\RoleManipulationInterface;

class RoleManipulator implements RoleManipulationInterface
{
    private $roles;

    public function __construct()
    {
        $this->roles = ["ROLE_USER"];
    }

    public function getRegularUserRoles(): array
    {
        return $this->roles;
    }
}