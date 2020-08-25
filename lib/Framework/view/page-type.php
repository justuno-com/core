<?php
/**
 * 2019-03-27
 * 2020-08-23 "Port the `df_is_catalog_product_view` function" https://github.com/justuno-com/core/issues/298
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @return bool
 */
function ju_is_catalog_product_view() {return ju_handle('catalog_product_view');}

/**
 * 2017-03-29
 * 2017-08-28
 * @todo May be we should use @see df_action() here?
 * @see  df_is_checkout_multishipping()
 * How to detect the «checkout success» page programmatically in PHP? https://mage2.pro/t/3562
 * 2020-08-24 "Port the `df_is_checkout_success` function" https://github.com/justuno-com/core/issues/310
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @return bool
 */
function ju_is_checkout_success() {return ju_handle('checkout_onepage_success');}