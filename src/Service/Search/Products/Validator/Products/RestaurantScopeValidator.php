<?php

/**
 * [x]- query string need to correspond to searcher
 *      all fields, which are required to run search MUST be either included initially or added manually
 * []- populated query params need to be validated
 */

namespace App\Service\Search\Products\Validator\Products;

use App\Service\Search\Products\Validator\ValidatorInterface;
use App\Service\Search\Products\Validator\Common\Validator;

class RestaurantScopeValidator extends Validator implements ValidatorInterface
{
    /**
     * check to see whether all required params is included into passed array
     * - if no
     *      except date and time everything else will be sanitized
     * - else
     *      use given 'queryParams' array
     *
     * @return null|array 'null' will interupt further sanitization if date or time is not defined
     */
    public function sanitizeQueryParams(array $queryParams): ?array
    {
        // yaml configuration fetching (defined by current app author) guarantee that
        // if parameter is not defined the null will be returned
        if (!$this->fetcher->getReservationTime($queryParams) || !$this->fetcher->getReservationDate($queryParams)) {
            return null;
        }

        elseif (!$this->fetcher->getRestaurantName($queryParams) || !$this->fetcher->getRestaurantId($queryParams)) {
            return null;
        }

        $queryParams = $this->sanitizePersonAmount($queryParams);

        return $queryParams;
    }

    public function validateQueryParams(array $queryParams, $objectForValidation): array
    {
        /**
         * []- object need to be defined to validate query params with 'symfony/validator'
         *
         *  note: after this method imp it just remains to define any controller
         *  dependent from these services!
         */

        $objectForValidation->setPersonAmount($queryParams[$this->keysFetcher->getPersonAmount()]);
        $objectForValidation->setRestaurantName($queryParams[$this->keysFetcher->getRestaurantName()]);
        $objectForValidation->setRestaurantId($queryParams[$this->keysFetcher->getRestaurantId()]);
        $objectForValidation->setReservationDate($queryParams[$this->keysFetcher->getReservationDate()]);
        $objectForValidation->setReservationTime($queryParams[$this->keysFetcher->getReservationTime()]);

        // validation
        $errors = $this->validator->validate($objectForValidation);

        if (count($errors) === 0) {
            // if no error is encountered then instead of empty array object is returned, which forces to have this imp
            return [];
        }
        // this can be empty or full
        return $errors;
    }
}