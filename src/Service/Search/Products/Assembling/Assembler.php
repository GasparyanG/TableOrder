<?php

namespace App\Service\Search\Products\Assembling;

use App\Service\Restaurant\RestaurantData\SingleRestaurantDataPreparingInterface;
use App\Service\Search\Products\Assembling\AssemblerInterface;

class Assembler implements AssemblerInterface
{
    // every restaurant will display at most this amount of tables
    private $amountOfTablesForRestaurant = 6;
    private $singleRestaurantDataPreparing;

    public function __construct(SingleRestaurantDataPreparingInterface $singleRestaurantDataPreparing)
    {
        $this->singleRestaurantDataPreparing = $singleRestaurantDataPreparing;
    }

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
                if (count($arrayToBeReturned[$resName]["tables"]) < 6) {
                    $arrayToBeReturned[$resName]["tables"][] = $table;
                }
            }

            else {
                // this will automatically set key for array
                $arrayToBeReturned[$resName]["tables"][] = $table;
                $arrayToBeReturned[$resName]["restaurant"]["restaurant"] = $this->singleRestaurantDataPreparing->populateRestaurant($table->getRestaurant());
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