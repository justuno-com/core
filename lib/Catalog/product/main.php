<?php
use Magento\Catalog\Model\Product as P;
use Magento\Framework\Exception\NotFoundException as NotFound;

/**
 * 2018-09-27
 * 2020-08-24 "Port the `df_product_current` function" https://github.com/justuno-com/core/issues/306
 * @used-by ju_product_current_id()
 * @param \Closure|bool|mixed $onError
 * @return P|null
 * @throws NotFound|\Exception
 */
function ju_product_current($onError = null) {return ju_try(function() {return
	ju_is_backend() ? ju_catalog_locator()->getProduct() : (df_registry('current_product') ?: ju_error())
;}, $onError);}

/**
 * 2019-11-15
 * 2020-08-24 "Port the `df_product_current_id` function" https://github.com/justuno-com/core/issues/305
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @return int|null
 */
function ju_product_current_id() {return !($p = ju_product_current() /** @var P $p */) ? null : $p->getId();}

/**
 * 2019-11-18
 * 2020-08-23 "Port the `df_product_id` function" https://github.com/justuno-com/core/issues/278
 * @used-by ju_qty()
 * @param P|int $p
 * @return int
 */
function ju_product_id($p) {return ju_int($p instanceof P ? $p->getId() : $p);}