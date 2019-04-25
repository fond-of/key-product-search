<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Communication\Plugin\ProductPageSearch;

use FondOfSpryker\Shared\KeyProductSearch\KeyProductSearchConstants;
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

        if (array_key_exists(KeyProductSearchConstants::MODEL_KEY, $attributes)) {
            $productAbstractPageSearchTransfer->setModelKey($attributes[KeyProductSearchConstants::MODEL_KEY]);
        }

        if (array_key_exists(KeyProductSearchConstants::STYLE_KEY, $attributes)) {
            $productAbstractPageSearchTransfer->setStyleKey($attributes[KeyProductSearchConstants::STYLE_KEY]);
        }

        if (array_key_exists(KeyProductSearchConstants::SIZE_KEY, $attributes)) {
            $productAbstractPageSearchTransfer->setSize($attributes[KeyProductSearchConstants::SIZE_KEY]);
        }

        if (array_key_exists(KeyProductSearchConstants::MODEL_SHORT, $attributes)) {
            $productAbstractPageSearchTransfer->setModelShort($attributes[KeyProductSearchConstants::MODEL_SHORT]);
        }
    }
}
