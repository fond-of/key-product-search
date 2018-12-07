<?php

namespace  FondOfSpryker\Client\KeyProductSearch;

use FondOfSpryker\Client\KeyProductSearch\Dependency\Client\KeyProductSearchToCatalogClientInterface;
use FondOfSpryker\Client\KeyProductSearch\Dependency\Client\KeyProductSearchToProductStorageClientInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilder;

class KeyProductSearchFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilderInterface
     */
    public function createQueryBuilder()
    {
        return new QueryBuilder();
    }

    /**
     * @return \FondOfSpryker\Client\KeyProductSearch\Dependency\Client\KeyProductSearchToCatalogClientInterface
     */
    public function getCatalogClient(): KeyProductSearchToCatalogClientInterface
    {
        return $this->getProvidedDependency(KeyProductSearchDependencyProvider::CLIENT_CATALOG);
    }

    /**
     *
     * @return \FondOfSpryker\Client\KeyProductSearch\Dependency\Client\KeyProductSearchToProductStorageClientInterface
     */
    public function getProductStorageClient(): KeyProductSearchToProductStorageClientInterface
    {
        return $this->getProvidedDependency(KeyProductSearchDependencyProvider::PRODUCT_STORAGE_CLIENT);
    }
}
