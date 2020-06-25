<?php
use Df\Core\R\ConT;
use Justuno\Core\Exception as DFE;
use ReflectionClass as RC;

/**
 * 2015-08-14 @uses get_class() does not add the leading slash `\` before the class name: http://3v4l.org/HPF9R
 * 2015-09-01
 * @uses ltrim() correctly handles Cyrillic letters: https://3v4l.org/rrNL9
 * 		echo ltrim('\\Путь\\Путь\\Путь', '\\');  => Путь\Путь\Путь
 * 2016-10-20 $c is required here because it is used by @used-by get_class(): https://3v4l.org/k6Hd5
 * 2020-06-26 "Port the `df_cts` function": https://github.com/justuno-com/core/issues/141
 * @used-by ju_explode_class()
 * @used-by ju_module_name()
 * @param string|object $c
 * @param string $del [optional]
 * @return string
 */
function ju_cts($c, $del = '\\') {/** @var string $r */
	$r = df_trim_text_right(is_object($c) ? get_class($c) : ltrim($c, '\\'), '\Interceptor');
	return '\\' === $del ? $r : str_replace('\\', $del, $r);
}

/**
 * 2020-06-26 "Port the `df_explode_class` function": https://github.com/justuno-com/core/issues/139
 * @used-by ju_module_name()
 * @param string|object $c
 * @return string[]
 */
function ju_explode_class($c) {return ju_explode_multiple(['\\', '_'], ju_cts($c));}