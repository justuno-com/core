<?php
use Magento\Catalog\Model\ResourceModel\Product\Collection as C;
/**
 * 2019-09-18
 * 2020-08-24 "Port the `df_product_c` function" https://github.com/justuno-com/core/issues/325
 * @used-by \Justuno\M2\Controller\Response\Catalog::execute()
 * @used-by \Justuno\M2\Controller\Response\Inventory::execute()
 * @return C
 */
function ju_product_c() {return df_new_om(C::class);}