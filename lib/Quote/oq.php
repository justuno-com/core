<?php
use Magento\Sales\Model\Order as O;

/**
 * 2017-04-10
 * 2020-06-24 "Port the `ju_is_o` function": https://github.com/justuno-com/core/issues/123
 * @used-by ju_store()
 * @param mixed $v
 * @return bool
 */
function ju_is_o($v) {return $v instanceof O;}

/**
 * 2020-02-05
 * 2020-08-24 "Port the `df_is_oqi` function" https://github.com/justuno-com/core/issues/319
 * @used-by ju_product()
 * @param mixed $v
 * @return bool
 */
function ju_is_oqi($v) {return df_is_oi($v) || df_is_qi($v);}

