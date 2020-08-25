<?php
/**
 * 2016-01-29
 * 2020-06-18 "Port the `df_ksort` function": https://github.com/justuno-com/core/issues/69
 * @used-by ju_ksort_r()
 * @used-by \Justuno\Core\Qa\Dumper::dumpArrayElements()
 * @param array(int|string => mixed) $a
 * @param callable|null $f [optional]
 * @return array(int|string => mixed)
 */
function ju_ksort(array $a, $f = null) {
	// 2020-08-25
	// «`exception.values.0.stacktrace.frames`: Discarded invalid value» / «Reason: expected an array» in Sentry:
	// https://github.com/mage2pro/core/issues/139
	if (ju_is_assoc($a)) {
		$f ? uksort($a, $f) : ksort($a);
	}
	return $a;
}

/**
 * 2017-07-05
 * 2020-06-18 "Port the `df_ksort_r` function": https://github.com/justuno-com/core/issues/68
 * @used-by ju_ksort_r()
 * @used-by ju_ksort_r_ci()
 * @param array(int|string => mixed) $a
 * @param callable|null $f [optional]
 * @return array(int|string => mixed)
 */
function ju_ksort_r(array $a, $f = null) {return ju_ksort(ju_map_k(function($k, $v) use($f) {return
	!is_array($v) ? $v : ju_ksort_r($v, $f)
;}, $a), $f);}

/**
 * 2017-08-22
 * 2017-09-07 Be careful! If the $a array is not associative,
 * then df_ksort_r($a, 'strcasecmp') will convert the numeric arrays to associative ones,
 * and their numeric keys will be ordered as strings.
 * 2020-06-18 "Port the `df_ksort_r_ci` function": https://github.com/justuno-com/core/issues/67
 * @used-by ju_json_sort()
 * @param array(int|string => mixed) $a       
 * @return array(int|string => mixed)
 */
function ju_ksort_r_ci(array $a) {return
	!ju_is_assoc($a)
	/**
	 * 2017-09-08
	 * @todo It would be nice to use df_sort($a) here,
	 * but now it will break the «Sales Documents Numeration» extension,
	 * because @see \Df\Config\Settings::_matrix() relies on an exact items ordering, e.g:
	 * [["ORD-{Y/m}-",null],["INV-",null],["SHIP-{Y-M}",null],["RET-{STORE-ID}-",null]]
	 * If we reorder these values, the «Sales Documents Numeration» extension will work incorrectly.
	 * I need to think how to improve it.
	 */
	? $a
	: ju_ksort_r($a, 'strcasecmp')
;}