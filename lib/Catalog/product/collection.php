<?php
use Closure as F;
use Justuno\Core\InventoryCatalog\Plugin\Model\ResourceModel\AddStockDataToCollection as PAddStock;
use Magento\Catalog\Model\ResourceModel\Product\Collection as C;
/**
 * 2019-09-18
 * 2020-08-24 "Port the `df_product_c` function" https://github.com/justuno-com/core/issues/325
 * @used-by \Justuno\M2\Controller\Response\Catalog::execute()
 * @used-by \Justuno\M2\Controller\Response\Inventory::execute()
 * @return C
 */
function ju_pc() {return ju_new_om(C::class);}

/**
 * 2020-11-23
 * @see ju_pc_preserve_absent_f()
 * "Add an ability to preserve disabled products in a collection
 * despite of the `cataloginventory/options/show_out_of_stock` option's value": https://github.com/mage2pro/core/issues/148
 * 2020-11-24
 * The solution works only if the «Use Flat Catalog Product» option is disabled.
 * If the the «Use Flat Catalog Product» option is enabled,
 * then the products collection is loaded directly from a `catalog_product_flat_<store>` table,
 * and such tables do not contain disabled products at least in Magento 2.4.0.
 * @used-by \Justuno\M2\Controller\Response\Catalog::execute()
 * @param C $c
 * @return C
 */
function ju_pc_preserve_absent(C $c) {return $c->setFlag(PAddStock::PRESERVE_ABSENT, true);}

/**
 * 2020-11-23
 * 1) "Add an ability to preserve out of stock (including just disabled) products in a collection
 * despite of the `cataloginventory/options/show_out_of_stock` option's value": https://github.com/mage2pro/core/issues/148
 * 2) @see ju_pc_preserve_absent() affects only a single explicitly accessible collection.
 * Sometimes it is not enough:
 * e.g. when we call @see \Magento\ConfigurableProduct\Model\Product\Type\Configurable::getUsedProducts()
 * the children collection is created internally (implicitly),
 * so we can not call @see ju_pc_preserve_absent() for it before it is loaded.
 * 2020-11-24
 * The solution works only if the «Use Flat Catalog Product» option is disabled.
 * If the the «Use Flat Catalog Product» option is enabled,
 * then the products collection is loaded directly from a `catalog_product_flat_<store>` table,
 * and such tables do not contain disabled products at least in Magento 2.4.0.
 * @used-by \Justuno\M2\Catalog\Variants::p()
 * @param F $f
 * @return mixed
 */
function ju_pc_preserve_absent_f(F $f) {
	try {
		$prev = PAddStock::$PRESERVE_ABSENT_F;
		PAddStock::$PRESERVE_ABSENT_F = true;
		$r = $f(); /** @var mixed $r */
	}
	finally {PAddStock::$PRESERVE_ABSENT_F = $prev;}
	return $r;
}