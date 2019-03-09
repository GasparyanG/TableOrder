<?php

namespace App\Service\BaseLayout;

interface BaseLayoutSupplierInterface
{
    public function getPersonAmount(): array;

    public function getLocation(): array;
}