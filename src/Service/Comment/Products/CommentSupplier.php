<?php

namespace App\Service\Comment\Products;

use App\Service\Comment\CommentFetcher\CommentFetcherInterface;
use App\Service\Comment\CommentSupplierInterface;

class CommentSupplier implements CommentSupplierInterface
{
    private $commentFetcher;

    public function __construct(CommentFetcherInterface $commentFetcher)
    {
        $this->commentFetcher = $commentFetcher;
    }

    public function getCommentFromPhpInputFile(): ?string
    {
        return $this->commentFetcher->getCommentFromPhpInputFile();
    }
}