<?php

namespace App\Service\ExternalSource;

interface ExternalSourceSupplierInterface
{
    public function getPhpInputFileContent(); // type can be mixed
}