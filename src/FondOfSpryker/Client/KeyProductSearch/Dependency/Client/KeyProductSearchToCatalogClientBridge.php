<?php

namespace FondOfSpryker\Client\KeyProductSearch\Dependency\Client;

use Spryker\Client\Catalog\CatalogClientInterface;

class KeyProductSearchToCatalogClientBridge implements KeyProductSearchToCatalogClientInterface
{
    /**
     * @var \Spryker\Client\Catalog\CatalogClientInterface
     */
    protected $catalogClient;

    /**
     * @param \Spryker\Client\Catalog\CatalogClientInterface $storageClient
     */
    public function __construct(CatalogClientInterface $catalogClient)
    {
        $this->catalogClient = $catalogClient;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function catalogSearch(string $searchString, array $requestParameters): array
    {
        return $this->catalogClient->catalogSearch($searchString, $requestParameters);
    }
}
