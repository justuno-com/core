<?php
use Magento\Framework\App\Area as A;

/**
 * 2016-09-30
 * 2017-04-02 «Area code is not set» on a df_area_code_is() call: https://mage2.pro/t/3581
 * 2020-06-24 "Port the `df_area_code_is` function": https://github.com/justuno-com/core/issues/126
 * @used-by ju_is_backend()
 * @param string ...$values
 * @return bool
 */
function ju_area_code_is(...$values) {return ($a = df_area_code(false)) && in_array($a, $values);}

/**
 * 2015-08-14
 * 2020-06-24 "Port the `df_is_backend` function": https://github.com/justuno-com/core/issues/125
 * @used-by ju_store()
 * @return bool
 */
function ju_is_backend() {return ju_area_code_is(A::AREA_ADMINHTML) || df_is_ajax() && df_backend_user();}