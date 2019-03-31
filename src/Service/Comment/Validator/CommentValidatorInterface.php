<?php

namespace App\Service\Comment\Validator;

interface CommentValidatorInterface
{
    public function validate(?string $comment): array;
}