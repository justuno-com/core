<?php
use Magento\Catalog\Model\Product as P;
/**
 * 2019-11-15
 * 2020-08-24 "Port the `df_product_current_id` function" https://github.com/justuno-com/core/issues/305
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @return int|null
 */
function ju_product_current_id() {return !($p = df_product_current() /** @var P $p */) ? null : $p->getId();}

/**
 * 2019-11-18
 * 2020-08-23 "Port the `df_product_id` function" https://github.com/justuno-com/core/issues/278
 * @used-by ju_qty()
 * @param P|int $p
 * @return int
 */
function ju_product_id($p) {return ju_int($p instanceof P ? $p->getId() : $p);}