<?php
/**
 * 2016-08-24
 * 2020-08-23 "Port the `df_handle` function" https://github.com/justuno-com/core/issues/299
 * @used-by ju_is_catalog_product_view()
 * @param string $n
 * @return bool
 */
function ju_handle($n) {return in_array($n, df_handles());}