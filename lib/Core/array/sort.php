<?php
/**
 * 2016-01-29
 * 2020-06-18 "Port the `df_ksort` function": https://github.com/justuno-com/core/issues/69
 * @used-by ju_ksort_r()
 * @used-by \Justuno\Core\Qa\Dumper::dumpArrayElements()
 * @param array(int|string => mixed) $a
 * @return array(int|string => mixed)
 */
function ju_ksort(array $a, callable $f = null):array {
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
 * @return array(int|string => mixed)
 */
function ju_ksort_r(array $a, callable $f = null):array {return ju_ksort(ju_map_k(function($k, $v) use($f) {return
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
function ju_ksort_r_ci(array $a):array {return
	array_is_list($a)
	/**
	 * 2017-09-08
	 * @todo It would be nice to use ju_sort($a) here,
	 * but now it will break the «Sales Documents Numeration» extension,
	 * because @see \Justuno\Core\Config\Settings::_matrix() relies on an exact items ordering, e.g:
	 * [["ORD-{Y/m}-",null],["INV-",null],["SHIP-{Y-M}",null],["RET-{STORE-ID}-",null]]
	 * If we reorder these values, the «Sales Documents Numeration» extension will work incorrectly.
	 * I need to think how to improve it.
	 */
	? $a
	: ju_ksort_r($a, 'strcasecmp')
;}

/**
 * 2016-07-18
 * 2016-08-10
 * С сегодняшнего дня я использую функцию @see df_caller_f(),
 * которая, в свою очередь, использует @debug_backtrace()
 * Это приводит к сбою: «Warning: usort(): Array was modified by the user comparison function».
 * http://stackoverflow.com/questions/3235387
 * https://bugs.php.net/bug.php?id=50688
 * По этой причине добавил собаку.
 * 2020-08-26 "Port the `df_sort` function" https://github.com/justuno-com/core/issues/334
 * @see ju_ksort()
 * @used-by ju_sort_names()
 * @used-by \Justuno\M2\Catalog\Images::p()
 * @used-by \Justuno\M2\Store::v()
 * @param array(int|string => mixed) $a
 * @param Closure|string|null $f [optional]
 * @return array(int|string => mixed)
 */
function ju_sort(array $a, $f = null):array {
	$isList = array_is_list($a); /** @var bool $isList */
	if (!$f) {
		$isList ? sort($a) : asort($a);
	}
	else {
		if (!$f instanceof Closure) {
			$f = function($a, $b) use($f) {return !is_object($a) ? $a - $b : $a->$f() - $b->$f();};
		}
		/** @noinspection PhpUsageOfSilenceOperatorInspection */
		$isList ? @usort($a, $f) : @uasort($a, $f);
	}
	return $a;
}

/**
 * 2017-02-02 http://stackoverflow.com/a/7930575
 * 2020-08-26 "Port the `df_sort_names` function" https://github.com/justuno-com/core/issues/332
 * 2022-11-30
 * «Deprecated Functionality: Collator::__construct():
 * Passing null to parameter #1 ($locale) of type string is deprecated
 * in vendor/justuno.com/core/lib/Core/array/sort.php on line 102»:
 * https://github.com/justuno-com/core/issues/379
 * @used-by ju_oqi_leafs()
 * @param string[]|mixed[] $a
 * @param callable|null $get
 * @return string[]|mixed[]
 */
function ju_sort_names(array $a, string $l = '', callable $get = null):array {
	$c = new Collator($l); /** @var Collator $c */
	return ju_sort($a, function($a, $b) use($c, $get) {return $c->compare(!$get ? $a : $get($a), !$get ? $b : $get($b));});
}