<?php

namespace App\Service\ClientSideGuru\Json\JsonNerd\Products;

use App\Service\ClientSideGuru\Json\JsonNerd\JsonNerdInterface;

class JsonNerd implements JsonNerdInterface
{
    public function convertToAssocArray(?array $jsonStoringArray): ?array
    {
        foreach($jsonStoringArray as $jsonStoringKey => $emptyValue) {
            // cycle will be done only one time, based on which desired key will be extracted from array!
        }

        // true means that return will be in assoc array format.
        $decodedJson = json_decode($jsonStoringKey, true);

        return $decodedJson;
    }
}