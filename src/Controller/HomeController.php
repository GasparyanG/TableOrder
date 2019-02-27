<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Search\Interfaces\SearchFormInterface;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function getPage(SearchFormInterface $formHelper, Request $request)
    {
        /**
         * 1) Request is needed to get queryString [x]
         * 2) psr container is needed to instantiate serrvice [x] already done in factory object
         * 3) run dispatcher to instantiate required abstract fatory
         * 4) getValidator()
         * 5) checkTime()
         * 6) sanitizeQueiryParams()
         * 7) validateQueryParams()
         * 8) getNotReservedTables()
        */

        return $this->render("home/main.html.twig", [
            "cities" => $formHelper->getLocationsForChoiceType(),
            "arrayOfPersonAmounts" => $formHelper->getPersonAmountArray()
        ]);
    }
}