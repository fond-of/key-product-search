<?php

namespace FondOfSpryker\Client\KeyProductSearch\Dependency\Client;

use Spryker\Client\ProductStorage\ProductStorageClientInterface;

class KeyProductSearchToProductStorageClientBridge implements KeyProductSearchToProductStorageClientInterface
{
    /**
     * @var \Spryker\Client\ProductStorage\ProductStorageClientInterface
     */
    protected $productStorageClient;

    public function __construct(ProductStorageClientInterface $productStorageClient)
    {
        $this->productStorageClient = $productStorageClient;
    }

    /**
     * @return void
     */
    public function findProductAbstractStorageData(int $idProductAbstract, string $localeName): ?array
    {
        return $this->productStorageClient->findProductAbstractStorageData($idProductAbstract, $localeName);
    }
}
