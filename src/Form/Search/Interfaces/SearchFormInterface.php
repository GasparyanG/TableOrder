<?php

namespace App\Form\Search\Interfaces;

interface SearchFormInterface
{
    public function getLocationsForChoiceType(): array;

    public function getPersonAmountArray(): array;
}