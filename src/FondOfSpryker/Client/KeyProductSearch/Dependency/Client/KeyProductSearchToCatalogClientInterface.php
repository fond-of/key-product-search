<?php

namespace FondOfSpryker\Client\KeyProductSearch\Dependency\Client;

interface KeyProductSearchToCatalogClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function catalogSearch(string $searchString, array $requestParameters): array;
}
