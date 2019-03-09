<?php

namespace App\Service\Search\AbstractFactory\Products;

use App\Service\Search\AbstractFactory\Interfaces\SearchAbstractFactoryInterface;
use App\Service\Search\AbstractFactory\Common\AbstractFactory;

// costume defined services
use App\Service\Search\Products\ObjectsForValidation\RestaurantGroupValidatorObject;
use App\Service\ClientSideGuru\QueryString\Search\QueryStringFetcherInterface;
use App\Service\Search\Products\Assembling\AssemblerInterface;
use App\Service\Search\Products\Searcher\Products\RestaurantGroupSearcher;
use App\Service\Search\Products\Validator\Products\RestaurantGroupValidator;

class RestaurantGroupSearchAbstractFactory extends AbstractFactory implements SearchAbstractFactoryInterface
{
    public function __construct(RestaurantGroupValidatorObject $objectForValidation, RestaurantGroupValidator $validator, RestaurantGroupSearcher $searcher, QueryStringFetcherInterface $fetcher, AssemblerInterface $assembler)
    {
        parent::__construct($fetcher);

        $this->objectForValidation = $objectForValidation;
        $this->validator = $validator;
        $this->searcher = $searcher;
        $this->assembler = $assembler;
    }

    public function isUsed(?string $behaviorType): bool
    {
        return $this->fetcher->getRestaurantGroupBehavior() === $behaviorType;
    }

    public function getSearcher()
    {
        return $this->searcher;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function getValidatorObject()
    {
        return $this->objectForValidation;
    }

    public function getAssembler()
    {
        return $this->assembler;
    }

    public function getConverter()
    {
        // TODO: Implement this method!
    }
}