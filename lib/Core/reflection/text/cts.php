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
 */
function ju_cts($c, $del = '\\'):string {/** @var string $r */
	$r = ju_trim_interceptor(is_object($c) ? get_class($c) : ltrim($c, '\\'));
	return '\\' === $del ? $r : str_replace('\\', $del, $r);
}