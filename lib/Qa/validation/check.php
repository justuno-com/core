<?php
/** 2022-10-15 @see is_iterable() has been added to PHP 7.1: https://www.php.net/manual/function.is-iterable.php */
if (!function_exists('is_iterable')) {
	/**
	 * 2016-08-09 http://stackoverflow.com/questions/31701517#comment59189177_31701556
	 * 2020-08-21 "Port the `df_check_traversable` function" https://github.com/justuno-com/core/issues/223
	 * @used-by juaf()
	 * @used-by ju_assert_traversable()
	 * @param \Traversable|array $v
	 * @return bool
	 */
	function is_iterable($v) {return is_array($v) || $v instanceof \Traversable;}
}

/**
 * 2020-06-22 "Port the `df_check_s` function": https://github.com/justuno-com/core/issues/109
 * @used-by ju_result_s()
 * @param string $v
 * @return bool
 */
function ju_check_s($v) {return \Justuno\Core\Zf\Validate\StringT::s()->isValid($v);}