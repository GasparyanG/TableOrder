<?php

namespace App\Service\Search\Products\Assembling;

interface AssemblerInterface
{
    public function assemble(array $notReservedTables): array;

    public function getAssembledTableArray(array $notReservedTables): array;
}