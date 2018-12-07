<?php

namespace  FondOfSpryker\Client\KeyProductSearch;

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
}
