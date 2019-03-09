<?php

namespace App\Service\BaseLayout\Products;

use App\Service\BaseLayout\BaseLayoutSupplierInterface;
use App\Form\Search\Interfaces\SearchFormInterface;

class BaseLayoutSupplier implements BaseLayoutSupplierInterface
{
    public function __construct(SearchFormInterface $formHelper)
    {
        $this->formHelper = $formHelper;
    }

    public function getPersonAmount(): array
    {
        return $this->formHelper->getPersonAmountArray();
    }

    public function getLocation(): array
    {
        return $this->formHelper->getLocationsForChoiceType();
    }
}