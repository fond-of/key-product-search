<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Communication;

use FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade\KeyProductSearchToAvailabilityFacadeInterface;
use FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade\KeyProductSearchToLocaleFacadeInterface;
use FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade\KeyProductSearchToStoreFacadeInterface;
use FondOfSpryker\Zed\KeyProductSearch\KeyProductSearchDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class KeyProductSearchCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade\KeyProductSearchToAvailabilityFacadeInterface
     */
    public function getAvailabilityFacade(): KeyProductSearchToAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(KeyProductSearchDependencyProvider::FACADE_AVAILABILITY);
    }

    /**
     * @return \FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade\KeyProductSearchToLocaleFacadeInterface
     */
    public function getLocaleFacade(): KeyProductSearchToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(KeyProductSearchDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade\KeyProductSearchToStoreFacadeInterface
     */
    public function getStoreFacade(): KeyProductSearchToStoreFacadeInterface
    {
        return $this->getProvidedDependency(KeyProductSearchDependencyProvider::FACADE_STORE);
    }
}
