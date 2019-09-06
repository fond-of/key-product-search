<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;

interface KeyProductSearchToLocaleFacadeInterface
{
    /**
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    public function getLocale(string $localeName): LocaleTransfer;
}
