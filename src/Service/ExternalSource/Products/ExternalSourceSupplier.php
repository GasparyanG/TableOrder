<?php

namespace App\Service\ExternalSource\Products;

use App\Service\ExternalSource\ExternalSourceSupplierInterface;

class ExternalSourceSupplier implements ExternalSourceSupplierInterface
{
    private $phpInputFile;

    public function __construct()
    {
        $this->phpInputFile = "php://input";
    }

    public function getPhpInputFileContent()
    {
        // this content does not processed by php yet
        $content = file_get_contents($this->phpInputFile);

        return $content;
    }
}