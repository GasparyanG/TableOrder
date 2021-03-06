<?php

namespace App\Controller;

use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\User\Data\Composed\UserDataComposerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use App\Service\ClientSideGuru\DefaultErrors\DefaultErrorMessageFetcherInterface;
use App\Form\Search\Interfaces\SearchFormInterface;

use App\Service\Search\Dispatcher\FactoryInterface;

class SearchController extends AbstractController
{
    public function getResult(Request $request,
                              FactoryInterface $factory,
                              LoggerInterface $logger,
                              DefaultErrorMessageFetcherInterface $defaultMsgFetcher,
                              UserDataComposerInterface $userDataComposer,
                              ClientDataComposerInterface $clientDataComposer,
                              SearchFormInterface $formHelper)
    {
        $queryParams = $request->query->all();

        $dataToReturnToClient = $clientDataComposer->composeData();

        // client required data: defaults
        $dataToReturnToClient["queryParams"] = $queryParams;
        $dataToReturnToClient["error"] = false;
        $dataToReturnToClient["notReservedTables"] = false;

        // add user
        $dataToReturnToClient["user"] = $userDataComposer->composeData();
        
        // $logger->info($dataToReturnToClient);
     
        $searcherAbstractFactory = $factory->create($queryParams);

        if (!$searcherAbstractFactory) {
            $dataToReturnToClient["error"] = true;
            return $this->render("search/index.html.twig", $dataToReturnToClient);
        }

        // validation section
        $validator = $searcherAbstractFactory->getValidator();
        $sanitizedQueryParams = $validator->sanitizeQueryParams($queryParams);

        if (!$sanitizedQueryParams) {
            $dataToReturnToClient["error"] = true;
            return $this->render("search/index.html.twig", $dataToReturnToClient);
        }

        $validatorObject = $searcherAbstractFactory->getValidatorObject();
        $errors = $validator->validateQueryParams($sanitizedQueryParams, $validatorObject);

        if (count($errors) > 0) {
            $dataToReturnToClient["error"] = true;
            return $this->render("search/index.html.twig", $dataToReturnToClient);
        }

        if (!$validator->checkTimeAndDate($sanitizedQueryParams)) {
            $dataToReturnToClient["error"] = true;
            return $this->render("search/index.html.twig", $dataToReturnToClient);
        }

        $searcher = $searcherAbstractFactory->getSearcher();
        
        $notReservedTables = $searcher->getNotReservedTables($sanitizedQueryParams);

        // assembler need to be added
        $assembler = $searcherAbstractFactory->getAssembler();
        // this will construct required data array structure (i.e. nested array with sorted tables against restaurant name)
        $notReservedTables = $assembler->assemble($notReservedTables);

        $dataToReturnToClient["notReservedTables"] = $notReservedTables;

        return $this->render('search/index.html.twig', $dataToReturnToClient);
    }
}