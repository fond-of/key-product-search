<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Communication\Plugin\ProductPageSearch;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageMapExpanderInterface;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

class KeyProductMapExpanderPlugin extends AbstractPlugin implements ProductPageMapExpanderInterface
{
    protected const MODEL_KEY = 'model_key';
    protected const STYLE_KEY = 'style_key';

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
        if (isset($productData[static::MODEL_KEY])) {
            $pageMapTransfer->setModelKey($productData[static::MODEL_KEY]);
        }

        if (isset($productData[static::STYLE_KEY])) {
            $pageMapTransfer->setStyleKey($productData[static::STYLE_KEY]);
        }

        return $pageMapTransfer;
    }
}
