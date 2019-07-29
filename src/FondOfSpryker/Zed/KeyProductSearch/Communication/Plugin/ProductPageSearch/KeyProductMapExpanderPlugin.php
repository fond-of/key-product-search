<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Communication\Plugin\ProductPageSearch;

use FondOfSpryker\Shared\KeyProductSearch\KeyProductSearchConstants;
use Generated\Shared\Search\PageIndexMap;
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
        $this->setModelKey($pageMapTransfer, $productData);
        $this->setStyleKey($pageMapTransfer, $productData);
        $this->setModelShort($pageMapTransfer, $productData);
        $this->setSize($pageMapTransfer, $pageMapBuilder, $productData);

        return $pageMapTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array $productData
     *
     * @return void
     */
    protected function setModelKey(PageMapTransfer $pageMapTransfer, array $productData): void
    {
        if (isset($productData[KeyProductSearchConstants::MODEL_KEY])) {
            $pageMapTransfer->setModelKey($productData[KeyProductSearchConstants::MODEL_KEY]);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array $productData
     *
     * @return void
     */
    protected function setStyleKey(PageMapTransfer $pageMapTransfer, array $productData): void
    {
        if (isset($productData[KeyProductSearchConstants::STYLE_KEY])) {
            $pageMapTransfer->setStyleKey($productData[KeyProductSearchConstants::STYLE_KEY]);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array $productData
     *
     * @return void
     */
    protected function setModelShort(PageMapTransfer $pageMapTransfer, array $productData): void
    {
        if (isset($productData[KeyProductSearchConstants::MODEL_SHORT])) {
            $pageMapTransfer->setModelShort($productData[KeyProductSearchConstants::MODEL_SHORT]);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param array $productData
     *
     * @return void
     */
    protected function setIsSoldOut(PageMapTransfer $pageMapTransfer, array $productData): void
    {
        if (isset($productData[KeyProductSearchConstants::IS_SOLD_OUT])) {
            $pageMapTransfer->setIsSoldOut($productData[KeyProductSearchConstants::IS_SOLD_OUT]);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     *
     * @return void
     */
    protected function setSize(PageMapTransfer $pageMapTransfer, PageMapBuilderInterface $pageMapBuilder, array $productData): void
    {
        $size = (ctype_digit($productData[PageIndexMap::SIZE]) === true) ?? 0;

        $pageMapBuilder->addIntegerSort($pageMapTransfer, PageIndexMap::SIZE, $size);
        $pageMapBuilder->addIntegerFacet($pageMapTransfer, PageIndexMap::SIZE, $size);

        if (isset($productData[KeyProductSearchConstants::SIZE_KEY])) {
            $pageMapTransfer->setSize($productData[KeyProductSearchConstants::SIZE_KEY]);
        }
    }
}
