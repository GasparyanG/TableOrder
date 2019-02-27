<?php
namespace App\Security\Hashing\Interfaces;

interface HasherInterface
{
    public function hash($dataToHash): string;
}