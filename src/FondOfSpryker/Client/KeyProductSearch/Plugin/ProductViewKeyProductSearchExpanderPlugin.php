<?php

namespace FondOfSpryker\Client\KeyProductSearch\Plugin;

use FondOfSpryker\Shared\KeyProductSearch\KeyProductSearchConstants;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\ProductStorage\Dependency\Plugin\ProductViewExpanderPluginInterface;

/**
 * @method \FondOfSpryker\Client\KeyProductSearch\KeyProductSearchFactory getFactory()
 */
class ProductViewKeyProductSearchExpanderPlugin extends AbstractPlugin implements ProductViewExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param array $productData
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer
     */
    public function expandProductViewTransfer(ProductViewTransfer $productViewTransfer, array $productData, $localeName)
    {
        $similarProducts = $this
            ->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                KeyProductSearchConstants::MODEL_KEY => $productViewTransfer->getAttributes()['model_key'],
                KeyProductSearchConstants::STYLE_KEY => $productViewTransfer->getAttributes()[KeyProductSearchConstants::STYLE_KEY],
                KeyProductSearchConstants::DONT_MERGE_SIZES => KeyProductSearchConstants::DONT_MERGE_SIZES,
            ]);

        $productViewTransfer->setSimilarProducts($this->getSimilarProductCollection($similarProducts, $localeName));

        return $productViewTransfer;
    }

    /**
     * @param array $similarProducts
     * @param string $localeName
     *
     * @return array
     */
    protected function getSimilarProductCollection(array $similarProducts, string $localeName): array
    {
        $collection = [];

        foreach ($similarProducts['products'] as $product) {
            array_push($collection, $this->getFactory()
                ->getProductStorageClient()
                ->findProductAbstractStorageData($product['id_product_abstract'], $localeName));
        }

        return $collection;
    }
}
