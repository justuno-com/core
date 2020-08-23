<?php
use Justuno\Core\Exception as DFE;
use Magento\Catalog\Model\Product as P;
use Magento\CatalogInventory\Api\StockConfigurationInterface as ICfg;
use Magento\CatalogInventory\Model\Configuration as Cfg;
use Magento\InventoryConfiguration\Model\IsSourceItemManagementAllowedForProductType as AllowedForPT;
use Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface as IAllowedForPT;
/**
 * 2019-11-22
 * 2020-08-23 "Port the `ju_assert_qty_supported` function" https://github.com/justuno-com/core/issues/275
 * @used-by ju_qty()
 * @param P $p
 * @throws DFE
 */
function ju_assert_qty_supported(P $p) {
	$t = $p->getTypeId(); /** @var string $t */
	ju_assert(ju_msi() ? ju_msi_allowed_for_pt()->execute($t) : df_stock_cfg()->isQty($t),
		"Products of type `$t` do not have a quantity."
	);
}

/**
 * 2019-11-21
 *	{
 *		"bundle": false,
 *		"configurable": false,
 *		"downloadable": true,
 *		"grouped": false,
 *		"simple": true,
 *		"virtual": true
 *	}
 * 2020-08-23 "Port the `df_msi_allowed_for_pt` function" https://github.com/justuno-com/core/issues/280
 * @used-by df_assert_qty_supported()
 * @return IAllowedForPT|AllowedForPT
 */
function ju_msi_allowed_for_pt() {return ju_o(IAllowedForPT::class);}