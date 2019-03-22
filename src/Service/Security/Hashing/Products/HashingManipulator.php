<?php

namespace App\Service\Security\Hashing\Products;

use App\Service\Security\Hashing\HashingManipulatorInterface;

class HashingManipulator implements HashingManipulatorInterface
{
    public function hash_md5(string $dataToHash): string
    {
        return hash("md5", $dataToHash);
    }

    public function hash_sha256(string $dataToHash): string
    {
        return hash("sha256", $dataToHash);
    }
}