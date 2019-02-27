<?php
namespace App\Security\Cookie\Creation\Interfaces;

interface HashMakingInterface
{
    public function makeCookie(): string;

    public function getTime(): int;
}