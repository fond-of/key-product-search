<?php

namespace FondOfSpryker\Client\KeyProductSearch;

use FondOfSpryker\Client\KeyProductSearch\Dependency\Client\KeyProductSearchToCatalogClientBridge;
use FondOfSpryker\Client\KeyProductSearch\Dependency\Client\KeyProductSearchToProductStorageClientBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class KeyProductSearchDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT_CATALOG = 'CLIENT_CATALOG';
    const PRODUCT_STORAGE_CLIENT = 'PRODUCT_STORAGE_CLIENT';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     */
    public function provideServiceLayerDependencies(Container $container)
    {
        $container = $this->addCatalogSearchClient($container);
        $container = $this->addProductStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addCatalogSearchClient(Container $container): Container
    {
        $container[static::CLIENT_CATALOG] = function (Container $container) {
            return new KeyProductSearchToCatalogClientBridge($container->getLocator()->catalog()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addProductStorageClient(Container $container): Container
    {
        $container[self::PRODUCT_STORAGE_CLIENT] = function (Container $container) {
            return new KeyProductSearchToProductStorageClientBridge($container->getLocator()->productStorage()->client());
        };

        return $container;
    }
}
