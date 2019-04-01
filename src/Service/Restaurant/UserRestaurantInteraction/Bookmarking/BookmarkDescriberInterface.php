<?php

namespace App\Service\Restaurant\UserRestaurantInteraction\Bookmarking;

interface BookmarkDescriberInterface
{
    public function getUserComposedBookmarks(bool $dashboard = true): array;

    public function getAmountOfUserBookmarks(): int;
}