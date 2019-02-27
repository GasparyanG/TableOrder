<?php

namespace App\Service\Search\AbstractFactory\Interfaces;

interface SearchAbstractFactoryInterface
{
    public function isUsed(?string $behaviorType): bool;

    public function getSearcher(); // add type hint

    public function getValidator(); // add type hint

    public function getValidatorObject(); // add type hint 

    public function getAssembler(); // add type hint
}