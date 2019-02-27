<?php

/**
 * [x]- add methods, which was been defined in implementor(s)
 * []- add type hint for '$objectForValidation'
 */
namespace App\Service\Search\Products\Validator;

interface ValidatorInterface
{
    public function sanitizeQueryParams(array $queryParams): ?array;

    /**
     * @param mixed[] $queryParams
     * @return array this array will either store errors or nothing (i.e. empty array)
     */
    public function validateQueryParams(array $queryParams, $objectForValidation): array;
    
    public function checkTimeAndDate(array $queryParams): bool;
}