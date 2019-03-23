<?php

namespace App\Templating\Configuration;

use App\Service\ConfigurationFetcher\Templating\TemplatingConfigFetcherInterface;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\TemplateNameParser;

class ConfiguredTemplateEngine
{
    private $templatingConfigFetcher;

    public function __construct(TemplatingConfigFetcherInterface $templatingConfigFetcher)
    {
        $this->templatingConfigFetcher = $templatingConfigFetcher;
    }

    public function getConfiguredTemplating()
    {
        $filesystemLoader = new FilesystemLoader(__DIR__ . "/../../../templates/%name%");

        $templating = new PhpEngine(new TemplateNameParser(), $filesystemLoader);

        return $templating;
    }
}