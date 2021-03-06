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
        $productViewTransfer
            ->setSimilarProducts($this->getSimilarProducts($productViewTransfer))
            ->setProductsWithSameStyleKey($this->getProductsWithSameStyleKey($productViewTransfer))
            ->setProductsWithSameModelKey($this->getProductsWithSameModelKey($productViewTransfer))
            ->setProductsSizeSwitcher($this->getProductsSizeSwitcher($productViewTransfer));

        return $productViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array
     */
    protected function getSimilarProducts(ProductViewTransfer $productViewTransfer): array
    {
        return $this
            ->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                KeyProductSearchConstants::MODEL_KEY => $productViewTransfer->getAttributes()['model_key'],
                KeyProductSearchConstants::STYLE_KEY => $productViewTransfer->getAttributes()[KeyProductSearchConstants::STYLE_KEY],
                KeyProductSearchConstants::DONT_MERGE_SIZES => KeyProductSearchConstants::DONT_MERGE_SIZES,
            ])['products'];
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array
     */
    protected function getProductsWithSameStyleKey(ProductViewTransfer $productViewTransfer): array
    {
        return $this
            ->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                KeyProductSearchConstants::STYLE_KEY => $productViewTransfer->getAttributes()[KeyProductSearchConstants::STYLE_KEY],
            ])['products'];
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array
     */
    protected function getProductsWithSameModelKey(ProductViewTransfer $productViewTransfer): array
    {
        return $this
            ->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                KeyProductSearchConstants::MODEL_KEY => $productViewTransfer->getAttributes()[KeyProductSearchConstants::MODEL_KEY],
            ])['products'];
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array
     */
    protected function getProductsSizeSwitcher(ProductViewTransfer $productViewTransfer): array
    {
        return $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                KeyProductSearchConstants::STYLE_KEY => $productViewTransfer->getAttributes()[KeyProductSearchConstants::STYLE_KEY],
                KeyProductSearchConstants::MODEL_SHORT => $productViewTransfer->getAttributes()[KeyProductSearchConstants::MODEL_SHORT],
                KeyProductSearchConstants::PLUGIN_SIZE_SWITCHER => KeyProductSearchConstants::PLUGIN_SIZE_SWITCHER,
            ])['products'];
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
