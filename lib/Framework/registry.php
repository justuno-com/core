<?php
use Magento\Framework\Registry as R;

/**
 * 2015-10-31
 * 2020-08-24 "Port the `df_registry` function" https://github.com/justuno-com/core/issues/308
 * @used-by ju_product_current()
 * @return mixed|null
 */
function ju_registry(string $k) {return ju_registry_o()->registry($k);}

/**
 * 2015-11-02 https://mage2.pro/t/95
 * 2020-08-24 "Port the `df_registry_o` function" https://github.com/justuno-com/core/issues/309
 * @used-by ju_registry()
 */
function ju_registry_o():R {return ju_o(R::class);}