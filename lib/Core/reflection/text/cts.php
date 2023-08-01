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