<?php

namespace App\Service\Search\AbstractFactory\Products;

use App\Service\Search\AbstractFactory\Interfaces\SearchAbstractFactoryInterface;
use App\Service\Search\AbstractFactory\Common\AbstractFactory;

// costume defined services
use App\Service\Search\Products\ObjectsForValidation\GlobalSearchObject;
use App\Service\Search\Products\Validator\Products\GlobalValidator;
use App\Service\Search\Products\Searcher\Products\GlobalSearcher;
use App\Service\ClientSideGuru\QueryString\Search\QueryStringFetcherInterface;
use App\Service\Search\Products\Assembling\AssemblerInterface;

class GlobalSearchAbstractFactory extends AbstractFactory implements SearchAbstractFactoryInterface
{
    public function __construct(GlobalSearchObject $objectForValidation, GlobalValidator $validator, GlobalSearcher $searcher, QueryStringFetcherInterface $fetcher, AssemblerInterface $assembler)
    {
        parent::__construct($fetcher);

        $this->objectForValidation = $objectForValidation;
        $this->validator = $validator;
        $this->searcher = $searcher;
        $this->assembler = $assembler;
    }

    public function isUsed(?string $behaviorType): bool
    {
        return $behaviorType === $this->fetcher->getGlobalBehavior();
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
}