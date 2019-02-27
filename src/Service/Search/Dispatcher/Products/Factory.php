<?php
/**
 * []- add products to property 'productsNames'
 * []- add namespace directory to property 'directoryNamespace'
 */
namespace App\Service\Search\Dispatcher\Products;

use App\Service\Search\Dispatcher\FactoryInterface;
use Psr\Container\ContainerInterface;
use App\Service\ClientSideGuru\QueryString\Search\QueryStringFetcherInterface;
use App\Service\Search\AbstractFactory\Interfaces\SearchAbstractFactoryInterface;

class Factory implements FactoryInterface
{
    private $productsNames;
    private $directoryNamespace;
    private $container;
    private $fetcher;

    public function __construct(ContainerInterface $container, QueryStringFetcherInterface $fetcher)
    {
        // services
        $this->fetcher = $fetcher;
        $this->container = $container;

        // static properties
        $this->directoryNamespace = "App\Service\Search\AbstractFactory\Products\\";
        $this->productsNames = [
            // add products as they get ready
            "GlobalSearchAbstractFactory"
        ];
    }

    /**
     * @param mixed[] $queryParams
     * @return null|SearchAbstractFactoryInterface if array of products will be traversed and 
     *      nothing choosed then 'null' will be returned
     */
    public function create(array $queryParams): ?SearchAbstractFactoryInterface
    {
        foreach($this->productsNames as $productName) {
            $fullyQualifiedNamespace = $this->directoryNamespace . $productName;
            $product = $this->container->get($fullyQualifiedNamespace);

            if ($product->isUsed($this->getBehavior($queryParams))) {
                return $product;
            }
        }

        return null;
    }

    private function getBehavior(array $queryParams): ?string
    {
        if (isset($queryParams[$this->fetcher->getBehaviorKey()])) {
            return $queryParams[$this->fetcher->getBehaviorKey()];
        }

        return null;
    }
}