<?php

namespace App\Service\Security\Hashing;

interface HashingManipulatorInterface
{
    public function hash_md5(string $dataToHash): string;

    public function hash_sha256(string $dataToHash): string;
}