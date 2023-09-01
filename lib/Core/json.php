<?php
use Closure as F;
use Justuno\Core\Exception as DFE;
use Justuno\Core\Json as J;
/**
 * «Returns the value encoded in json in appropriate PHP type.
 * Values true, false and null are returned as TRUE, FALSE and NULL respectively.
 * NULL is returned if the json cannot be decoded or if the encoded data is deeper than the recursion limit.»
 * https://php.net/manual/function.json-decode.php
 * 2020-06-26 "Port the `df_json_decode` function": https://github.com/justuno-com/core/issues/152
 * @used-by ju_module_json()
 * @used-by ju_package()
 * @param string|null $s
 * @return array|mixed|bool|null
 * @throws DFE
 */
function ju_json_decode($s, bool $throw = true) {/** @var mixed|bool|null $r */
	# 2022-10-14
	# «an empty string is no longer considered valid JSON»:
	# https://php.net/manual/migration70.incompatible.php#migration70.incompatible.other.json-to-jsond
	if (ju_nes($s)) {
		$r = $s;
	}
	else {
		# 2016-10-30
		# json_decode('7700000000000000000000000') возвращает 7.7E+24
		# https://3v4l.org/NnUhk
		# http://stackoverflow.com/questions/28109419
		# Такие длинные числоподобные строки используются как идентификаторы КЛАДР
		# (модулем доставки «Деловые Линии»), и поэтому их нельзя так корёжить.
		# Поэтому используем константу JSON_BIGINT_AS_STRING
		# https://3v4l.org/vvFaF
		$r = json_decode($s, true, 512, JSON_BIGINT_AS_STRING);
		# 2016-10-28
		# json_encode(null) возвращает строку 'null', а json_decode('null') возвращает null.
		# Добавил проверку для этой ситуации, чтобы не считать её сбоем.
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
 * 2023-08-30 "Implement `ju_json_dont_sort()`": https://github.com/justuno-com/core/issues/402
 * @see ju_json_sort()
 * @used-by ju_dump_ds()
 * @return mixed
 */
function ju_json_dont_sort(F $f) {/** @var mixed $r */
	$prev = J::bSort(); /** @var bool $prev */
	J::bSort(false);
	try {$r = $f();}
	finally {J::bSort($prev);}
	return $r;
}

/**
 * 2015-12-06
 * 2020-06-18 "Port the `df_json_encode` function": https://github.com/justuno-com/core/issues/65
 * @used-by ju_js_x()
 * @used-by ju_json_encode_partial()
 * @used-by ju_kv()
 * @used-by ju_log_l()
 * @used-by \Justuno\Core\Framework\W\Result\Json::prepare()
 * @used-by \Justuno\Core\Qa\Dumper::dumpArray()
 * @used-by \Justuno\Core\Sentry\Client::encode()
 * @used-by \Justuno\Core\Sentry\Extra::adjust()
 * @param mixed $v
 */
function ju_json_encode($v, int $flags = 0):string {return json_encode(ju_json_sort($v),
	JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE | $flags
);}

/**
 * 2020-02-15
 * 2020-06-18 "Port the `df_json_encode_partial` function": https://github.com/justuno-com/core/issues/91
 * @used-by \Justuno\Core\Qa\Dumper::dumpObject()
 * @param mixed $v
 */
function ju_json_encode_partial($v):string {return ju_json_encode($v, JSON_PARTIAL_OUTPUT_ON_ERROR);}

/**
 * 2017-09-07
 * I use @uses ju_is_assoc() check,
 * because otherwise @uses ju_ksort_r_ci() will convert the numeric arrays to associative ones,
 * and their numeric keys will be ordered as strings.
 * 2020-06-18 "Port the `df_json_sort` function": https://github.com/justuno-com/core/issues/66
 * @see ju_json_dont_sort()
 * @used-by ju_json_decode()
 * @used-by ju_json_encode()
 * @param mixed $v
 * @return mixed
 */
function ju_json_sort($v) {return !is_array($v) || !J::bSort() ? $v : ju_ksort_r_ci($v);}