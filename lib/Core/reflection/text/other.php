<?php




/**
 * 2015-08-14 @uses get_class() does not add the leading slash `\` before the class name: http://3v4l.org/HPF9R
 * 2015-09-01
 * @uses ltrim() correctly handles Cyrillic letters: https://3v4l.org/rrNL9
 * 		echo ltrim('\\Путь\\Путь\\Путь', '\\');  => Путь\Путь\Путь
 * 2016-10-20 $c is required here because it is used by @used-by get_class(): https://3v4l.org/k6Hd5
 * 2020-06-26 "Port the `df_cts` function": https://github.com/justuno-com/core/issues/141
 * @used-by ju_cc_method()
 * @used-by ju_explode_class()
 * @used-by ju_explode_class_camel()
 * @used-by ju_fe_init()
 * @used-by ju_module_name()
 * @param string|object $c
 * @param string $del [optional]
 * @return string
 */
function ju_cts($c, $del = '\\') {/** @var string $r */
	$r = ju_trim_text_right(is_object($c) ? get_class($c) : ltrim($c, '\\'), '\Interceptor');
	return '\\' === $del ? $r : str_replace('\\', $del, $r);
}

/**
 * 2016-04-11 Dfe_CheckoutCom => dfe_checkout_com
 * @used-by ju_report_prefix()
 */
function ju_cts_lc_camel(string $c, string $del):string {return implode($del, ju_explode_class_lc_camel($c));}

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
 * @used-by ju_cts_lc_camel()
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