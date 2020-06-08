<?php

namespace FondOfSpryker\Client\KeyProductSearch\Plugin\Elasticsearch\QueryExpander;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfSpryker\Shared\KeyProductSearch\KeyProductSearchConstants;
use Generated\Shared\Search\PageIndexMap;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\Search\Plugin\Config\SortConfigBuilder;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * Class SizeSearchExpanderPlugin
 *
 * @package FondOfSpryker\Client\KeyProductSearch\Plugin\Elasticsearch\QueryExpander
 * @method \FondOfSpryker\Client\KeyProductSearch\KeyProductSearchFactory getFactory()
 */
class SizeSearchExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @var \FondOfSpryker\Client\KeyProductSearch\KeyProductSearchConfig
     */
    protected $config;

    public function __construct()
    {
        $this->config = $this->getFactory()->getKeyProductSearchConfig();
    }

    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        if (!array_key_exists(KeyProductSearchConstants::DONT_MERGE_SIZES, $requestParameters)) {
            return $searchQuery;
        }

        $boolQuery = $this->getBoolQuery($searchQuery->getSearchQuery());

        foreach ($this->config->getModelKeys() as $item) {
            $boolQuery->addMust($this->createShouldModelKeyQuery($item));
        }

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
                'order' => SortConfigBuilder::DIRECTION_ASC,
                'mode' => 'min',
            ],
        ]);
    }

    /**
     * @param string $modelKey
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function createShouldModelKeyQuery(string $modelKey)
    {
        $boolQuery = $this->getFactory()
            ->createBoolQuery()
            ->addShould($this->createQueryModelKeyAndSize($modelKey))
            ->addShould($this->createQueryModelKeyNotEqual($modelKey));

        return $boolQuery;
    }

    /**
     * @param string $modelkey
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function createQueryModelKeyAndSize(string $modelkey)
    {
        $queryModelKey = $this->getFactory()
            ->createQueryBuilder()
            ->createTermQuery(KeyProductSearchConstants::MODEL_KEY, $modelkey);

        $querySize = $this->getFactory()
            ->createBoolQuery()
            ->addMust($this->getFactory()
                ->createQueryBuilder()
                ->createMatchQuery()
                ->setField(KeyProductSearchConstants::SIZE_KEY, 'S'));

        $boolQuey = $this->getFactory()
            ->createBoolQuery()
            ->addShould($queryModelKey)
            ->addMust($querySize);

        return $boolQuey;
    }

    /**
     * @param string $modelKey
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function createQueryModelKeyNotEqual(string $modelKey)
    {
        $boolQuery = $this->getFactory()
            ->createBoolQuery()
            ->addMustNot($this->getFactory()
                ->createQueryBuilder()
                ->createMatchQuery()
                ->setField('model_key', $modelKey));

        return $boolQuery;
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
