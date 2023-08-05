<?php
/**
 * 2020-06-13 "Port the `dfa` function": https://github.com/justuno-com/core/issues/12
 * @used-by ju_asset_create()
 * @used-by ju_block()
 * @used-by ju_bt_entry_class()
 * @used-by ju_bt_entry_file()
 * @used-by ju_bt_entry_func()
 * @used-by ju_bt_entry_line()
 * @used-by ju_caller_m()
 * @used-by ju_cc_method()
 * @used-by ju_cli_argv()
 * @used-by jua_merge_r()
 * @used-by ju_is_localhost()
 * @used-by ju_log_l()
 * @used-by ju_magento_version()
 * @used-by ju_my_local()
 * @used-by ju_package()
 * @used-by ju_prop()
 * @used-by ju_referer()
 * @used-by ju_request()
 * @used-by ju_request_method()
 * @used-by ju_sentry()
 * @used-by ju_sentry_m()
 * @used-by ju_x_entry()
 * @used-by jutr()
 * @used-by \Justuno\Core\Helper\Text::quote()
 * @used-by \Justuno\Core\O::a()
 * @used-by \Justuno\Core\Qa\Trace::__construct()
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodParameter()
 * @used-by \Justuno\Core\Sentry\Client::__construct()
 * @used-by \Justuno\Core\Sentry\Client::capture()
 * @used-by \Justuno\Core\Sentry\Client::captureException()
 * @used-by \Justuno\Core\Sentry\Client::needSkipFrame()
 * @used-by \Justuno\Core\Sentry\Trace::get_default_context()
 * @used-by \Justuno\Core\Sentry\Trace::get_frame_context()
 * @used-by \Justuno\Core\Sentry\Trace::info()
 * @used-by \Justuno\Core\Zf\Validate::cfg()
 * @used-by \Justuno\M2\Store::v()
 * @param array(int|string => mixed) $a
 * @param string|string[]|int|null $k
 * @param mixed|callable $d
 * @return mixed|null|array(string => mixed)
 */
function jua(array $a, $k, $d = null) {return
	ju_nes($k) ? $a : (is_array($k)
		/**
		 * 2022-11-26
		 * Added `!$k`.
		 * @see df_arg() relies on it if its argument is an empty array:
		 *		df_arg([]) => []
		 *		dfa($a, df_arg([])) => $a
		 * https://3v4l.org/C09vn
		 */
		? (!$k ? $a : jua_select_ordered($a, $k))
		: (isset($a[$k]) ? $a[$k] : (ju_contains($k, '/') ? jua_deep($a, $k, $d) : ju_call_if($d, $k)))
	)
;}

/**
 * 2015-02-08
 * 2020-01-29
 * 1) It returns a subset of $a with $k keys in the same order as in $k.
 * 2) Normally, you should use @see jua() instead because it is shorter and calls jua_select_ordered() internally.
 * 2020-06-13 "Port the `jua_select_ordered` function": https://github.com/justuno-com/core/issues/13
 * @used-by jua()
 * @param array(string => string)|T $a
 * @param string[] $k
 * @return array(string => string)
 */
function jua_select_ordered($a, array $k):array  {
	$resultKeys = array_fill_keys($k, null); /** @var array(string => null) $resultKeys */
	/**
	 * 2017-10-28
	 * During the last 2.5 years, I had the following code here:
	 * 		array_merge($resultKeys, df_ita($source))
	 * It worked wronly, if $source contained SOME numeric-string keys like "99":
	 * https://github.com/mage2pro/core/issues/40#issuecomment-340139933
	 *
	 * «A key may be either an integer or a string.
	 * If a key is the standard representation of an integer, it will be interpreted as such
	 * (i.e. "8" will be interpreted as 8, while "08" will be interpreted as "08").»
	 * https://php.net/manual/language.types.array.php
	 *
	 * «If, however, the arrays contain numeric keys, the later value will not overwrite the original value,
	 * but will be appended.
	 * Values in the input array with numeric keys will be renumbered
	 * with incrementing keys starting from zero in the result array.»
	 * https://php.net/manual/function.array-merge.php
	 * https://github.com/mage2pro/core/issues/40#issuecomment-340140297
	 * `df_ita($source) + $resultKeys` does not solve the problem,
	 * because the result keys are ordered in the `$source` order, not in the `$resultKeys` order:
	 * https://github.com/mage2pro/core/issues/40#issuecomment-340140766
	 * @var array(string => string) $resultWithGarbage
	 */
	$resultWithGarbage = jua_merge_numeric($resultKeys, ju_ita($a));
	/**
	 * 2023-07-20
	 * 1) Today I found a bug (at least, in PHP 8.2) in this old function.
	 * 		$a: {"EUR": "Euro", "USD": "US Dollar"}
	 * 		$k: ["CAD", "PHP", "USD"]
	 * 		Result (wrong because it is not a subset of $a): {"CAD": null, "PHP": null, "USD": "US Dollar"}
	 * 2) It led to the error: «df_option(): Argument #2 ($l) must be of type string, null given»:
	 * https://github.com/mage2pro/core/issues/238
	 * 3) So I have added @uses ju_clean_null()
	 */
	return ju_clean_null(array_intersect_key($resultWithGarbage, $resultKeys));
}