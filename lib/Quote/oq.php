<?php
use Magento\Quote\Model\Quote\Item as QI;
use Magento\Sales\Model\Order as O;
use Magento\Sales\Model\Order\Item as OI;

/**
 * 2017-04-10
 * 2020-06-24 "Port the `ju_is_o` function": https://github.com/justuno-com/core/issues/123
 * @used-by ju_oqi_leafs()
 * @used-by ju_store()
 * @param mixed $v
 * @return bool
 */
function ju_is_o($v) {return $v instanceof O;}

/**
 * 2017-04-20
 * 2020-08-24 "Port the `df_is_oi` function" https://github.com/justuno-com/core/issues/321
 * @used-by ju_is_oqi()
 * @param mixed $v
 * @return bool
 */
function ju_is_oi($v) {return $v instanceof OI;}

/**
 * 2020-02-05
 * 2020-08-24 "Port the `df_is_oqi` function" https://github.com/justuno-com/core/issues/319
 * @used-by ju_product()
 * @param mixed $v
 * @return bool
 */
function ju_is_oqi($v) {return ju_is_oi($v) || ju_is_qi($v);}

/**
 * 2017-04-20
 * 2020-08-24 "Port the `df_is_qi` function" https://github.com/justuno-com/core/issues/322
 * @used-by ju_is_oqi()
 * @param mixed $v
 * @return bool
 */
function ju_is_qi($v) {return $v instanceof QI;}