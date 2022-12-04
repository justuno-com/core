<?php
use Magento\Framework\Phrase;
/** 2022-10-15 @see is_iterable() has been added to PHP 7.1: https://www.php.net/manual/function.is-iterable.php */
if (!function_exists('is_iterable')) {
	/**
	 * 2016-08-09 http://stackoverflow.com/questions/31701517#comment59189177_31701556
	 * 2020-08-21 "Port the `df_check_traversable` function" https://github.com/justuno-com/core/issues/223
	 * @used-by juaf()
	 * @used-by ju_assert_traversable()
	 * @param Traversable|array $v
	 */
	function is_iterable($v):bool {return is_array($v) || $v instanceof Traversable;}
}

/**
 * 2015-02-16
 * Раньше здесь стояло просто `is_string($value)`
 * Однако интерпретатор PHP способен неявно и вполне однозначно (без двусмысленностей, как, скажем, с вещественными числами)
 * конвертировать целые числа и `null` в строки,
 * поэтому пусть целые числа и `null` всегда проходят валидацию как строки.
 * 2016-07-01 Добавил `|| $value instanceof Phrase`
 * 2017-01-13 Добавил `|| is_bool($value)`
 * 2020-06-22 "Port the `df_check_s` function": https://github.com/justuno-com/core/issues/109
 * @used-by ju_result_s()
 * @param mixed $v
 */
function ju_check_s($v):bool {return is_string($v) || is_int($v) || is_null($v) || is_bool($v) || $v instanceof Phrase;}