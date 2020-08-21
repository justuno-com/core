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

