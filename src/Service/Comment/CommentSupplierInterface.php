<?php

namespace App\Service\Comment;

interface CommentSupplierInterface
{
    public function getCommentFromPhpInputFile(): ?string;
}