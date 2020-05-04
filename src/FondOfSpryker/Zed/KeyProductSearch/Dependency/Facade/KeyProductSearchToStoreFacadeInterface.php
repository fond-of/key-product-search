<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface KeyProductSearchToStoreFacadeInterface
{
    /**
     * @param  string  $storeName
     *
     * @return \Generated\Shared\Transfer\StoreTransfer|null
     */
    public function findStoreByName(
        string $storeName
    ): ?StoreTransfer;
}
