<?php

namespace App\Service\Search\SearchFlow\Products;

// costume made services
use App\Service\Search\Dispatcher\FactoryInterface;

// http foundation
use Symfony\Component\HttpFoundation\Request;

// log
use Psr\Log\LoggerInterface;

use App\Service\Search\SearchFlow\SearchFlowInterface;

class RestaurantSearchFlow implements SearchFlowInterface
{
    public function __construct(LoggerInterface $logger, FactoryInterface $factory)
    {
        // costume
        $this->factory = $factory;
        // log
        $this->request = Request::createFromGlobals();
        // http
        $this->logger = $logger;
    }

    public function getNotReservedTables(): ?array
    {
        $queryParams = $this->request->query->all();
        // getting abstract factory
        $abstractFactory = $this->factory->create($queryParams);

        if (!$abstractFactory) {
            return null;
        }

        // validation section
        $validator = $abstractFactory->getValidator();
        $sanitizedQueryParams = $validator->sanitizeQueryParams($queryParams);

        if (!$sanitizedQueryParams) {
            return null;
        }

        $this->logger->info("start");
        $this->logger->info(json_encode($sanitizedQueryParams));
        $this->logger->info("end");

        // validating with validator object
        $validatorObject = $abstractFactory->getValidatorObject();
        $errors = $validator->validateQueryParams($sanitizedQueryParams, $validatorObject);

        if (count($errors) > 0) {
            return null;
        }

        $this->logger->info("start");
        $this->logger->info("all is perfectly settled");
        $this->logger->info("end");

        // time checking
        if (!$validator->checkTimeAndDate($sanitizedQueryParams)) {
            return null;
        }

        $this->logger->info("start");
        $this->logger->info("time and date are also correct");
        $this->logger->info("end");

        // searching
        $searcher = $abstractFactory->getSearcher();
        $notReservedTables = $searcher->getNotReservedTables($sanitizedQueryParams);

        if (!$notReservedTables) {
            return null;
        }

        // no available tables
        elseif(count($notReservedTables) === 0) {
            $this->logger->info("start");
            $this->logger->info("There is no available tables");
            $this->logger->info("end");
            return [];
        }

        $this->logger->info("start");
        $this->logger->info(count($notReservedTables));
        $this->logger->info("end");

        // assembling
        $assembler = $abstractFactory->getAssembler();
        $notReservedTables = $assembler->getAssembledTableArray($notReservedTables);

        $this->logger->info("start");
        $this->logger->info(count($notReservedTables));
        $this->logger->info("end");

        // $converter = $abstractFactory->getConverter();

        // $convertedArray = $converter->convert($notReservedTables);
        // this need to be removed at the end!
        return $notReservedTables;
    }
}