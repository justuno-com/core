<?php
use Justuno\Core\Exception as DFE;
/**
 * «Returns the value encoded in json in appropriate PHP type.
 * Values true, false and null are returned as TRUE, FALSE and NULL respectively.
 * NULL is returned if the json cannot be decoded or if the encoded data is deeper than the recursion limit.»
 * http://php.net/manual/function.json-decode.php
 * 2020-06-26 "Port the `df_json_decode` function": https://github.com/justuno-com/core/issues/152
 * @used-by ju_module_json()
 * @used-by ju_package()
 * @param string|null $s
 * @param bool $throw [optional]
 * @return array|mixed|bool|null
 * @throws DFE
 */
function ju_json_decode($s, $throw = true) {/** @var mixed|bool|null $r */
	if ('' === $s || is_null($s)) {
		$r = $s;
	}
	else {
		$r = json_decode($s, true, 512, JSON_BIGINT_AS_STRING);
		if (is_null($r) && 'null' !== $s && $throw) {
			ju_assert_ne(JSON_ERROR_NONE, json_last_error());
			ju_error(
				"Parsing a JSON document failed with the message «%s».\nThe document:\n{$s}"
				,json_last_error_msg()
			);
		}
	}
	return ju_json_sort($r);
}

/**
 * 2015-12-06
 * 2020-06-18 "Port the `df_json_encode` function": https://github.com/justuno-com/core/issues/65
 * @used-by ju_js_x()
 * @used-by ju_json_encode_partial()
 * @used-by ju_kv()
 * @used-by ju_log_l()
 * @used-by \Justuno\Core\Framework\W\Result\Json::prepare()
 * @used-by \Justuno\Core\O::j()
 * @used-by \Justuno\Core\Sentry\Client::capture()
 * @used-by \Justuno\Core\Sentry\Client::encode()
 * @used-by \Justuno\Core\Sentry\Extra::adjust()
 * @param mixed $v
 * @param int $flags [optional]
 * @return string
 */
function ju_json_encode($v, $flags = 0) {return json_encode(ju_json_sort($v),
	JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE | $flags
);}

/**
 * 2020-02-15
 * 2020-06-18 "Port the `df_json_encode_partial` function": https://github.com/justuno-com/core/issues/91
 * @used-by \Justuno\Core\Qa\Dumper::dumpObject()
 * @param mixed $v
 * @return string
 */
function ju_json_encode_partial($v) {return ju_json_encode($v, JSON_PARTIAL_OUTPUT_ON_ERROR);}

/**
 * 2017-09-07
 * I use the @uses ju_is_assoc() check,
 * because otherwise @uses ju_ksort_r_ci() will convert the numeric arrays to associative ones,
 * and their numeric keys will be ordered as strings.
 * 2020-06-18 "Port the `df_json_sort` function": https://github.com/justuno-com/core/issues/66
 * @used-by ju_json_decode()
 * @used-by ju_json_encode()
 * @param mixed $v
 * @return mixed
 */
function ju_json_sort($v) {return !is_array($v) ? $v : (ju_is_assoc($v) ? ju_ksort_r_ci($v) :
	/**
	 * 2017-09-08
	 * @todo It would be nice to use df_sort($v) here,
	 * but now it will break the «Sales Documents Numeration» extension,
	 * because @see \Df\Config\Settings::_matrix() relies on an exact items ordering, e.g:
	 * [["ORD-{Y/m}-",null],["INV-",null],["SHIP-{Y-M}",null],["RET-{STORE-ID}-",null]]
	 * If we reorder these values, the «Sales Documents Numeration» extension will work incorrectly.
	 * I need to think how to improve it.
	 */
	$v
);}