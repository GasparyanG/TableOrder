<?php

namespace App\Controller;

use App\Service\BaseLayout\ClientDataComposerInterface;
use App\Service\Bridge\LoginAuthentication\LoginAuthenticationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{
    private $clientDataComposer;

    public function __construct(ClientDataComposerInterface $clientDataComposer)
    {
        $this->clientDataComposer = $clientDataComposer;
    }

    public function getPage()
    {
        $dataForClient = $this->clientDataComposer->composeData();
        $dataForClient["errors"] = [];

        return $this->render("login/index.html.twig", $dataForClient);
    }

    public function login(LoginAuthenticationInterface $loginAuthentication)
    {
        $dataForClient = $this->clientDataComposer->composeData();

        $errors = $loginAuthentication->validateInputs();

        // i.e. no errors at all
        if (!$errors) {
            if ($loginAuthentication->isValid()){
                // renew user cookie
                $loginAuthentication->renewCookie();

                return $this->redirectToRoute("dashboard");
            }

            else {
                // add this error to default error configurations
                $errors = ["Email or password is incorrect. Try again please."];
            }
        }

        // make this dynamic!
        $dataForClient["errors"] = $errors;

        return $this->render("login/index.html.twig", $dataForClient);
    }
}
