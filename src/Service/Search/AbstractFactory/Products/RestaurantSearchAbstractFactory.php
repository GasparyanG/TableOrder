<?php

namespace App\Service\Search\AbstractFactory\Products;

use App\Service\Search\AbstractFactory\Interfaces\SearchAbstractFactoryInterface;
use App\Service\Search\AbstractFactory\Common\AbstractFactory;

// costume defined services
use App\Service\Search\Products\ObjectsForValidation\RestaurantScopeSearchObject;
use App\Service\ClientSideGuru\QueryString\Search\QueryStringFetcherInterface;
use App\Service\Search\Products\Assembling\AssemblerInterface;
use App\Service\Search\Products\Searcher\Products\RestaurantScopeSearcher;
use App\Service\Search\Products\Validator\Products\RestaurantScopeValidator;
use App\Service\Search\ConverterForAjax\Products\RestaurantScopeConverter;

class RestaurantSearchAbstractFactory extends AbstractFactory implements SearchAbstractFactoryInterface
{
    // this params will be changed at every sequential step
    public function __construct(RestaurantScopeSearchObject $objectForValidation, RestaurantScopeValidator $validator, RestaurantScopeSearcher $searcher, QueryStringFetcherInterface $fetcher, AssemblerInterface $assembler, RestaurantScopeConverter $converter)
    {
        parent::__construct($fetcher);

        $this->converter = $converter;
        $this->objectForValidation = $objectForValidation;
        $this->validator = $validator;
        $this->searcher = $searcher;
        $this->assembler = $assembler;
    }

    public function isUsed(?string $behaviorType): bool
    {
        return $behaviorType === $this->fetcher->getRestaurantBehavior();
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
        return $this->converter;
    }
}