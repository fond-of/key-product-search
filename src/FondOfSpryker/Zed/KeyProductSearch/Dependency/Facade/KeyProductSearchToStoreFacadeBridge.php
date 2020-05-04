<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class KeyProductSearchToStoreFacadeBridge implements KeyProductSearchToStoreFacadeInterface
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * KeyProductSearchToStoreFacadeBridge constructor.
     *
     * @param  \Spryker\Zed\Store\Business\StoreFacadeInterface  $storeFacade
     */
    public function __construct(StoreFacadeInterface $storeFacade)
    {
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param  string  $storeName
     *
     * @return \Generated\Shared\Transfer\StoreTransfer|null
     */
    public function findStoreByName(
        string $storeName
    ): ?StoreTransfer {
        return $this->storeFacade->findStoreByName($storeName);
    }
}
