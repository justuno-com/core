<?php
use Magento\Catalog\Model\Product as P;

/**
 * 2019-11-18
 * 2020-08-23 "Port the `df_product_id` function" https://github.com/justuno-com/core/issues/278
 * @used-by ju_qty()
 * @param P|int $p
 * @return int
 */
function ju_product_id($p) {return df_int($p instanceof P ? $p->getId() : $p);}