<?php

namespace App\Service\Comment\CommentFetcher;

interface CommentFetcherInterface
{
    public function getCommentFromPhpInputFile(): ?string;
}