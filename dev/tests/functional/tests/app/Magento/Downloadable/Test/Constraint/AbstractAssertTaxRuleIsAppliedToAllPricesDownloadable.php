<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Downloadable\Test\Constraint;

use Magento\Cms\Test\Page\CmsIndex;
use Magento\Catalog\Test\Page\Category\CatalogCategoryView;
use Magento\Catalog\Test\Page\Product\CatalogProductView;
use Magento\Checkout\Test\Page\CheckoutCart;
use Magento\Tax\Test\Constraint\AbstractAssertTaxRuleIsAppliedToAllPrices;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\Fixture\InjectableFixture;

/**
 * Checks that product prices excl tax on category, product and cart pages are equal to specified in dataset.
 */
abstract class AbstractAssertTaxRuleIsAppliedToAllPricesDownloadable extends AbstractAssertTaxRuleIsAppliedToAllPrices
{
    /**
     * Constraint severeness.
     *
     * @var string
     */
    protected $severeness = 'high';

    /**
     * Assert that specified prices are actual on category, product and cart pages.
     *
     * @param InjectableFixture $product
     * @param array $prices
     * @param int $qty
     * @param CmsIndex $cmsIndex
     * @param CatalogCategoryView $catalogCategoryView
     * @param CatalogProductView $catalogProductView
     * @param CheckoutCart $checkoutCart
     * @param FixtureFactory $fixtureFactory
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function processAssert(
        InjectableFixture $product,
        array $prices,
        $qty,
        CmsIndex $cmsIndex,
        CatalogCategoryView $catalogCategoryView,
        CatalogProductView $catalogProductView,
        CheckoutCart $checkoutCart,
        FixtureFactory $fixtureFactory
    ) {
        $this->cmsIndex = $cmsIndex;
        $this->catalogCategoryView = $catalogCategoryView;
        $this->catalogProductView = $catalogProductView;
        $this->checkoutCart = $checkoutCart;
        $actualPrices = [];
        //Assertion steps
        $productName = $product->getName();
        $productCategory = $product->getCategoryIds()[0];
        $this->openCategory($productCategory);
        $actualPrices = $this->getCategoryPrices($productName, $actualPrices);
        $catalogCategoryView->getListProductBlock()->openProductViewPage($productName);
        $catalogProductView->getViewBlock()->fillOptions($product);
        $actualPrices = $this->getProductPagePrices($actualPrices);
        $catalogProductView->getViewBlock()->clickAddToCart();
        $actualPrices = $this->getCartPrices($product, $actualPrices);
        $actualPrices = $this->getTotals($actualPrices);
        //Prices verification
        $message = 'Prices from dataset should be equal to prices on frontend';
        \PHPUnit_Framework_Assert::assertEquals($prices, $actualPrices, $message);
    }
}
