<?php
/**
 * 2019-03-27
 * 2020-08-23 "Port the `df_is_catalog_product_view` function" https://github.com/justuno-com/core/issues/298
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @return bool
 */
function ju_is_catalog_product_view() {return ju_handle('catalog_product_view');}