<?php

namespace App\Service\Search\ConverterForAjax;

interface ConverterForAjaxInterface
{
    public function convert(array $arrayToConvert): array;
}