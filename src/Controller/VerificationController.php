<?php

namespace App\Controller;

use App\Service\BaseLayout\BaseLayoutSupplierInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VerificationController extends AbstractController
{
    public function getPage(BaseLayoutSupplierInterface $baseLayoutSupplier)
    {
        $arrayOfData = $this->getBaseLayoutComponents($baseLayoutSupplier);

        return $this->render('verification/index.html.twig', $arrayOfData);
    }

    public function verify(BaseLayoutSupplierInterface $baseLayoutSupplier)
    {
        $arrayOfData = $this->getBaseLayoutComponents($baseLayoutSupplier);
        // TODO: verify!
    }

    private function getBaseLayoutComponents($baseLayoutSupplier): array
    {
        $arrayOfData = [];

        $arrayOfData["cities"] = $baseLayoutSupplier->getLocation();
        $arrayOfData["arrayOfPersonAmounts"] = $baseLayoutSupplier->getPersonAmount();

        return $arrayOfData;
    }
}
