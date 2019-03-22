<?php

namespace App\Service\User\Authority\Roles;

interface RoleManipulationInterface
{
    public function getRegularUserRoles(): array;

    // TODO: add roles for admin, superUser, etc.
}