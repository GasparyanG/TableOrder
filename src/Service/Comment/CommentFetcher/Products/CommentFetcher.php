<?php

namespace App\Service\Comment\CommentFetcher\Products;

use App\Service\Comment\CommentFetcher\CommentFetcherInterface;

// Http foundation
use App\Service\ConfigurationFetcher\Keys\KeysFetcherInterface;
use App\Service\ExternalSource\ExternalSourceSupplierInterface;

class CommentFetcher implements CommentFetcherInterface
{
    private $externalSourceSupplier;
    private $keysFetcher;

    public function __construct(KeysFetcherInterface $keysFetcher, ExternalSourceSupplierInterface $externalSourceSupplier)
    {
        $this->externalSourceSupplier = $externalSourceSupplier;
        $this->keysFetcher = $keysFetcher;
    }

    public function getCommentFromPhpInputFile(): string
    {
        // data from $_POST
        $content = $this->externalSourceSupplier->getPhpInputFileContent();
        $assocArrayFromClient = json_decode($content, true);

        return $assocArrayFromClient[$this->keysFetcher->getComment()];
    }
}