<?php

namespace FondOfSpryker\Client\KeyProductSearch;

use FondOfSpryker\Shared\KeyProductSearch\KeyProductSearchConstants;
use Spryker\Client\Kernel\AbstractBundleConfig;

class KeyProductSearchConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getModelKeys(): array
    {
        return $this->get(KeyProductSearchConstants::MODEL_KEYS_FOR_SIZE_FILTER, []);
    }
}
