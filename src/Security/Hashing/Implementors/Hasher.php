<?php
namespace App\Security\Hashing\Implementors;

use App\Security\Hashing\Interfaces\HasherInterface;

class Hasher implements HasherInterface
{
    private $algorithm;

    public function __construct()
    {
        $this->algorithm = "md5";
    }

    public function hash($dataToHash): string
    {
        return hash($this->algorithm, $dataToHash);
    }
}