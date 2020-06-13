<?php
use Magento\Framework\App\ObjectManager as OM;
use Magento\Framework\ObjectManagerInterface as IOM;

/**
 * 2020-06-13 "Port the `df_o` function": https://github.com/justuno-com/core/issues/3
 * @used-by ju_request_o()
 * @param string $t
 * @return mixed
 */
function ju_o($t) {return dfcf(function($t) {return ju_om()->get($t);}, [$t]);}

/**
 * 2020-06-13 "Port the `df_om` function": https://github.com/justuno-com/core/issues/4
 * @used-by ju_o()
 * @return OM|IOM
 */
function ju_om() {return OM::getInstance();}