<?php

namespace FondOfSpryker\Client\KeyProductSearch\Plugin\Elasticsearch\QueryExpander;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfSpryker\Shared\KeyProductSearch\KeyProductSearchConstants;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfSpryker\Client\KeyProductSearch\KeyProductSearchFactory getFactory()
 */
class KeyProductExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        if (!array_key_exists(KeyProductSearchConstants::MODEL_KEY, $requestParameters) &&
            !array_key_exists(KeyProductSearchConstants::STYLE_KEY, $requestParameters)) {
            return $searchQuery;
        }

        $boolQuery = $this->getBoolQuery($searchQuery->getSearchQuery());
        $termQueries = [];

        if (array_key_exists(KeyProductSearchConstants::MODEL_KEY, $requestParameters)) {
            array_push($termQueries, $this->getFactory()
                ->createQueryBuilder()
                ->createTermQuery(
                    KeyProductSearchConstants::MODEL_KEY,
                    $requestParameters[KeyProductSearchConstants::MODEL_KEY]
                ));
        }

        if (array_key_exists(KeyProductSearchConstants::STYLE_KEY, $requestParameters)) {
            array_push($termQueries, $this->getFactory()
                ->createQueryBuilder()
                ->createTermQuery(
                    KeyProductSearchConstants::STYLE_KEY,
                    $requestParameters[KeyProductSearchConstants::STYLE_KEY]
                ));
        }

        $boolQuery->addMust($termQueries);

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     *
     * @throws \InvalidArgumentException
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function getBoolQuery(Query $query)
    {
        $boolQuery = $query->getQuery();
        if (!$boolQuery instanceof BoolQuery) {
            throw new InvalidArgumentException(sprintf(
                'Localized query expander available only with %s, got: %s',
                BoolQuery::class,
                get_class($boolQuery)
            ));
        }

        return $boolQuery;
    }
}
