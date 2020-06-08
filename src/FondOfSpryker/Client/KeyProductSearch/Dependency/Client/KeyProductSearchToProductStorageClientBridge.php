<?php

namespace FondOfSpryker\Client\KeyProductSearch\Dependency\Client;

use Spryker\Client\ProductStorage\ProductStorageClientInterface;

class KeyProductSearchToProductStorageClientBridge implements KeyProductSearchToProductStorageClientInterface
{
    /**
     * @var \Spryker\Client\ProductStorage\ProductStorageClientInterface
     */
    protected $productStorageClient;

    /**
     * @param ProductStorageClientInterface $productStorageClient
     */
    public function __construct(ProductStorageClientInterface $productStorageClient)
    {
        $this->productStorageClient = $productStorageClient;
    }

    /**
     * @return null|array
     */
    public function findProductAbstractStorageData(int $idProductAbstract, string $localeName): ?array
    {
        return $this->productStorageClient->findProductAbstractStorageData($idProductAbstract, $localeName);
    }
}
