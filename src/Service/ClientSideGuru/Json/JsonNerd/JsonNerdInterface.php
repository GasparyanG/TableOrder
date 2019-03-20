<?php

namespace App\Service\ClientSideGuru\Json\JsonNerd;

interface JsonNerdInterface
{
    public function convertToAssocArray(?array $jsonStoringArray): ?array;
}