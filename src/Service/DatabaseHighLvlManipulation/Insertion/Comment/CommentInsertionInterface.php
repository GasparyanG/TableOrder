<?php

namespace App\Service\DatabaseHighLvlManipulation\Insertion\Comment;

interface CommentInsertionInterface
{
    public function insertToDatabase(string $comment, int $restaurantId): void;
}