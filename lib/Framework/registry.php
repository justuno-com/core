<?php
use Magento\Framework\Registry as R;

/**
 * 2015-10-31
 * 2020-08-24 "Port the `df_registry` function" https://github.com/justuno-com/core/issues/308
 * @used-by ju_product_current()
 * @param string $k
 * @return mixed|null
 */
function ju_registry($k) {return df_registry_o()->registry($k);}