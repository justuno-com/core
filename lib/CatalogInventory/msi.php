<?php
use Magento\Catalog\Model\Product as P;
use Magento\Framework\Exception\NoSuchEntityException as NSE;
use Magento\InventorySales\Model\ResourceModel\GetAssignedStockIdForWebsite as StockIdForWebsite;
use Magento\InventorySalesApi\Model\GetAssignedStockIdForWebsiteInterface as IStockIdForWebsite;
use Magento\Store\Model\Store;
use Magento\Store\Model\Website as W;
/**
 * 2019-11-22
 * 2020-08-23 "Port the `df_msi` function" https://github.com/justuno-com/core/issues/276
 * @used-by ju_assert_qty_supported()
 * @used-by ju_qty()
 * @return bool
 */
function ju_msi() {return jucf(function() {return df_module_enabled('Magento_Inventory');});}