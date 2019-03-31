<?php

namespace App\Service\Comment\AjaxHandler;

interface AjaxHandlerInterface
{
    public function addComment(int $restaurantId): bool;
}