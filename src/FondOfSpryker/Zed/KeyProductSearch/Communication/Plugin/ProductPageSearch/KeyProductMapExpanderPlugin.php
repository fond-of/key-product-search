<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Communication\Plugin\ProductPageSearch;

use FondOfSpryker\Shared\KeyProductSearch\KeyProductSearchConstants;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageMapExpanderInterface;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

class KeyProductMapExpanderPlugin extends AbstractPlugin implements ProductPageMapExpanderInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductPageMap(PageMapTransfer $pageMapTransfer, PageMapBuilderInterface $pageMapBuilder, array $productData, LocaleTransfer $localeTransfer): PageMapTransfer
    {
        if (isset($productData[KeyProductSearchConstants::MODEL_KEY])) {
            $pageMapTransfer->setModelKey($productData[KeyProductSearchConstants::MODEL_KEY]);
        }

        if (isset($productData[KeyProductSearchConstants::STYLE_KEY])) {
            $pageMapTransfer->setStyleKey($productData[KeyProductSearchConstants::STYLE_KEY]);
        }

        if (isset($productData[KeyProductSearchConstants::SIZE_KEY])) {
            $pageMapTransfer->setSize($productData[KeyProductSearchConstants::SIZE_KEY]);
        }

        return $pageMapTransfer;
    }
}
