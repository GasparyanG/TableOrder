<?php

namespace App\Service\Search\Products\Assembling;

use App\Service\Search\Products\Assembling\AssemblerInterface;

class Assembler implements AssemblerInterface
{
    // every restaurant will display at most this amount of tables
    private $amountOfTablesForRestaurant = 6;

    /**
     * @param array $notReservedTables array of RestaurantTable objects
     * 
     * @return array nested array
     */
    public function assemble(array $notReservedTables): array
    {
        $arrayToBeReturned = [];
        foreach($notReservedTables as $table) {
            $resName = $table->getRestaurant()->getName();
            if (isset($arrayToBeReturned[$resName])) {
                if (count($arrayToBeReturned[$resName]) < 6) {
                    $arrayToBeReturned[$resName][] = $table;
                }
            }

            else {
                // this will automatically set key for array
                $arrayToBeReturned[$resName][] = $table;
            }
        }

        return $arrayToBeReturned;
    }

    public function getAssembledTableArray(array $notReservedTables): array
    {
        $assembledArray = $this->assemble($notReservedTables);

        foreach($assembledArray as $tableArray) {
            return $tableArray;
        }
    }
}