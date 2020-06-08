<?php

namespace FondOfSpryker\Client\KeyProductSearch\Plugin\Elasticsearch\QueryExpander;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfSpryker\Shared\KeyProductSearch\KeyProductSearchConstants;
use Generated\Shared\Search\PageIndexMap;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchElasticsearch\Config\SortConfig;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @package FondOfSpryker\Client\KeyProductSearch\Plugin\Elasticsearch\QueryExpander
 * @method \FondOfSpryker\Client\KeyProductSearch\KeyProductSearchFactory getFactory()
 */
class ModelKeyAndStyleKeyQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * Specification:
     *  - Expands base query.
     *
     * @api
     *
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        if (!array_key_exists(KeyProductSearchConstants::MODEL_KEY, $requestParameters)) {
            return $searchQuery;
        }

        if (!array_key_exists(KeyProductSearchConstants::STYLE_KEY, $requestParameters)) {
            return $searchQuery;
        }

        $modelKey = $requestParameters[KeyProductSearchConstants::MODEL_KEY];
        $styleKey = $requestParameters[KeyProductSearchConstants::STYLE_KEY];
        $boolQuery = $this->getBoolQuery($searchQuery->getSearchQuery());

        $matchModelKeyQuery = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery()
            ->setField(KeyProductSearchConstants::MODEL_KEY, $modelKey);

        $matchStyleKeyQuery = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery()
            ->setField(KeyProductSearchConstants::STYLE_KEY, $styleKey);

        $boolQuery->addMust($matchModelKeyQuery);
        $boolQuery->addMust($matchStyleKeyQuery);

        $this->addSort($searchQuery->getSearchQuery());

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $searchQuery
     *
     * @return void
     */
    protected function addSort(Query $searchQuery): void
    {
        $searchQuery->addSort([
            PageIndexMap::INTEGER_SORT . '.' . PageIndexMap::SIZE => [
                'order' => SortConfig::DIRECTION_ASC,
                'mode' => 'min',
            ],
        ]);
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
