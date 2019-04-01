<?php

namespace App\Service\Bookmark;

interface BookmarkSupplierInterface
{
    public function getUserComposedBookmarks(bool $dashboard = true): array;

    public function getAmountOfUserBookmarks(): int;
}