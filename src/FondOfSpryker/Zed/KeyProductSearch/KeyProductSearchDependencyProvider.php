<?php

namespace FondOfSpryker\Zed\KeyProductSearch;

use FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade\KeyProductSearchToAvailabilityFacadeBridge;
use FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade\KeyProductSearchToLocaleFacadeBridge;
use FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade\KeyProductSearchToStoreFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class KeyProductSearchDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_AVAILABILITY = 'AVAILABILITY';

    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addAvailabilityFacade($container);
        $container = $this->addLocaleFacade($container);
        $container = $this->addStoreFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAvailabilityFacade(Container $container): Container
    {
        $container[static::FACADE_AVAILABILITY] = function (Container $container) {
            return new KeyProductSearchToAvailabilityFacadeBridge(
                $container->getLocator()->availability()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleFacade(Container $container): Container
    {
        $container[static::FACADE_LOCALE] = function (Container $container) {
            return new KeyProductSearchToLocaleFacadeBridge(
                $container->getLocator()->locale()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = function (Container $container) {
            return new KeyProductSearchToStoreFacadeBridge(
                $container->getLocator()->store()->facade()
            );
        };

        return $container;
    }
}
