<?php

namespace FondOfSpryker\Client\KeyProductSearch\Dependency\Client;

interface KeyProductSearchToProductStorageClientInterface
{
    /**
     * @param int $idProductAbstract
     * @param string $localeName
     *
     * @return array|null
     */
    public function findProductAbstractStorageData(int $idProductAbstract, string $localeName): ?array;
}
