<?php

namespace FondOfSpryker\Zed\KeyProductSearch\Communication\Plugin\ProductPageSearch;

use FondOfSpryker\Shared\KeyProductSearch\KeyProductSearchConstants;
use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

/**
 * @method \FondOfSpryker\Zed\KeyProductSearch\Communication\KeyProductSearchCommunicationFactory getFactory()
 */
class KeyProductMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands and returns the provided PageMapTransfer objects data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductMap(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer
    ): PageMapTransfer {
        $this->setModelKey($pageMapTransfer, $productData);
        $this->setStyleKey($pageMapTransfer, $productData);
        $this->setModelShort($pageMapTransfer, $productData);
        $this->setIsSoldOut($pageMapTransfer, $pageMapBuilder, $productData);
        $this->setAvailable($pageMapTransfer, $pageMapBuilder, $productData);
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
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     *
     * @return void
     */
    protected function setIsSoldOut(PageMapTransfer $pageMapTransfer, PageMapBuilderInterface $pageMapBuilder, array $productData): void
    {
        $soldOut = array_key_exists(KeyProductSearchConstants::IS_SOLD_OUT, $productData) ?? false;

        $pageMapTransfer->setIsSoldOut($soldOut);
        $pageMapBuilder->addSearchResultData($pageMapTransfer, KeyProductSearchConstants::IS_SOLD_OUT, $soldOut);
    }

    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     *
     * @return void
     */
    protected function setAvailable(PageMapTransfer $pageMapTransfer, PageMapBuilderInterface $pageMapBuilder, array $productData): void
    {
        if (!array_key_exists('locale', $productData) || !array_key_exists('id_product_abstract', $productData)) {
            return;
        }

        $storeTransfer = $this->getFactory()->getStoreFacade()->findStoreByName($productData['store']);

        $productAbstractAvailabilityTransfer = $this->getFactory()
            ->getAvailabilityFacade()
            ->findOrCreateProductAbstractAvailabilityBySkuForStore($productData['sku'], $storeTransfer);

        $available = $productAbstractAvailabilityTransfer->getAvailability()->greaterThan(0) ? true : false;

        $pageMapTransfer->setAvailable($available);
        $pageMapBuilder->addSearchResultData($pageMapTransfer, PageMapTransfer::AVAILABLE, $available);
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
        $size = (ctype_digit($productData[PageIndexMap::SIZE]) === true) ? $productData[PageIndexMap::SIZE] : 0;

        $pageMapBuilder->addIntegerSort($pageMapTransfer, PageIndexMap::SIZE, $size);
        $pageMapBuilder->addIntegerFacet($pageMapTransfer, PageIndexMap::SIZE, $size);

        if (isset($productData[KeyProductSearchConstants::SIZE_KEY])) {
            $pageMapTransfer->setSize($productData[KeyProductSearchConstants::SIZE_KEY]);
        }
    }
}
