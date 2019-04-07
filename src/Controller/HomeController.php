<?php

namespace App\Controller;

use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\ConfigurationFetcher\Templating\TemplatingConfigFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function getPage(ClientDataComposerInterface $clientDataComposer,
                            TemplatingConfigFetcherInterface $templatingConfigFetcher)
    {
        $dataForClient = $clientDataComposer->composeData();
        $dataForClient[$templatingConfigFetcher->getSearchState()] = false;

        return $this->render("home/main.html.twig", $dataForClient);
    }
}