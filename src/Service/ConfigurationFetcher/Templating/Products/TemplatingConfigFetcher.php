<?php

namespace App\Service\ConfigurationFetcher\Templating\Products;

use App\Service\ConfigurationFetcher\Templating\TemplatingConfigFetcherInterface;
use Symfony\Component\Yaml\Yaml;

class TemplatingConfigFetcher implements TemplatingConfigFetcherInterface
{
    private $twigConfig;
    private $templateVarsConfig;

    public function __construct()
    {
        $this->twigConfig = Yaml::parseFile(__DIR__ . "/../../../../../config/packages/twig.yaml");
        $this->templateVarsConfig = Yaml::parseFile(__DIR__ . "/../../../../../config/packages/client_side_guru/template/template_vars.yaml");
    }

    public function getDefaultPath(): string
    {
        return $this->twigConfig["twig"]["default_path"];
    }

    public function getVerificationCodeVar(): string
    {
        return $this->templateVarsConfig["verification"]["verificationCode"];
    }

    public function getPersonAmount(): string
    {
        return $this->templateVarsConfig["navBar"]['search']['personAmount'];
    }

    public function getCities(): string
    {
        return $this->templateVarsConfig["navBar"]['search']['cities'];
    }

    public function getUser(): string
    {
        return $this->templateVarsConfig["navBar"]['user']['user'];
    }

    public function getReview(): string
    {
        return $this->templateVarsConfig["rating"]['review'];
    }

    public function getRestaurantRating(): string
    {
        return $this->templateVarsConfig["rating"]['restaurantRating'];
    }

    public function getNotificationData(): string
    {
        return $this->templateVarsConfig["notification"]['notificationData'];
    }
}