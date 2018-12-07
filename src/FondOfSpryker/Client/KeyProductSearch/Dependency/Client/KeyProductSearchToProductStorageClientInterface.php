<?php

namespace FondOfSpryker\Client\KeyProductSearch\Dependency\Client;

interface KeyProductSearchToProductStorageClientInterface
{
    public function findProductAbstractStorageData(int $idProductAbstract, string $localeName): ?array;
}
