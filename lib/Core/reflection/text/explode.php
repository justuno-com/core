<?php

/**
 * 2020-06-26 "Port the `df_explode_class` function": https://github.com/justuno-com/core/issues/139
 * @used-by ju_class_f()
 * @used-by ju_class_l()
 * @used-by ju_explode_class_lc()
 * @used-by ju_module_name()
 * @param string|object $c
 * @return string[]
 */
function ju_explode_class($c) {return ju_explode_multiple(['\\', '_'], ju_cts($c));}

/**
 * 2016-04-11 Dfe_CheckoutCom => [Dfe, Checkout, Com]
 * 2016-10-20
 * Making $c optional leads to the error «get_class() called without object from outside a class»: https://3v4l.org/k6Hd5
 * 2020-08-21 "Port the `df_explode_class_camel` function" https://github.com/justuno-com/core/issues/220
 * @used-by ju_explode_class_lc_camel()
 * @param string|object $c
 * @return string[]
 */
function ju_explode_class_camel($c) {return jua_flatten(ju_explode_camel(explode('\\', ju_cts($c))));}

/**
 * 2016-01-14
 * 2016-10-20
 * Making $c optional leads to the error «get_class() called without object from outside a class»: https://3v4l.org/k6Hd5
 * 2020-08-22 "Port the `ju_explode_class_lc` function" https://github.com/justuno-com/core/issues/243
 * @param string|object $c
 * @return string[]
 */
function ju_explode_class_lc($c) {return ju_lcfirst(ju_explode_class($c));}

/**
 * 2016-04-11
 * 2016-10-20
 * 1) Making $c optional leads to the error «get_class() called without object from outside a class»: https://3v4l.org/k6Hd5
 * 2) Dfe_CheckoutCom => [dfe, checkout, com]
 * 2020-08-21 "Port the `df_explode_class_lc_camel` function" https://github.com/justuno-com/core/issues/217
 * @used-by ju_module_name_lc()
 * @param string|object $c
 * @return string[]
 */
function ju_explode_class_lc_camel($c) {return ju_lcfirst(ju_explode_class_camel($c));}

/**
 * 2021-02-24
 * @used-by ju_caller_c()
 * @param string $m
 * @return string[]
 */
function ju_explode_method($m) {return explode('::', $m);}