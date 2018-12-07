<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Communication\Plugin\ProductPageSearch;

use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

class KeyProductDataExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
{
    /**
     * @api
     *
     * @param array $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return void
     */
    public function expandProductPageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer): void
    {
        $attributes = json_decode($productData['attributes'], true);

        if (array_key_exists('model_key', $attributes)) {
            $productAbstractPageSearchTransfer->setModelKey($attributes['model_key']);
        }

        if (array_key_exists('style_key', $attributes)) {
            $productAbstractPageSearchTransfer->setStyleKey($attributes['style_key']);
        }
    }
}
