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
    public function expandProductViewTransfer(ProductViewTransfer $productViewTransfer, array $productData, $localeName)
    {
        $similarProducts = $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                KeyProductSearchConstants::MODEL_KEY => KeyProductSearchConstants::SHOE_MODEL_KEY,
                KeyProductSearchConstants::STYLE_KEY => $productViewTransfer->getAttributes()['style_key'],
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
