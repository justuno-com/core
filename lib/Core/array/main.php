<?php
/**
 * 2020-06-14 "Port the `df_array` function": https://github.com/justuno-com/core/issues/21
 * @used-by ju_explode_xpath()
 * @used-by ju_fe_init()
 * @used-by ju_find()
 * @used-by ju_map()
 * @param mixed|mixed[] $v
 * @return mixed[]|string[]|float[]|int[]
 */
function ju_array($v):array {return is_array($v) ? $v : [$v];}

/**
 * 2020-06-13 "Port the `df_ita` function": https://github.com/justuno-com/core/issues/15
 * 2022-10-18
 * @uses iterator_to_array() allows an array as the first argument since PHP 8.2:
 * https://www.php.net/manual/migration82.other-changes.php#migration82.other-changes.functions.spl
 * 2023-07-26 "Replace `array|Traversable` with `iterable`": https://github.com/mage2pro/core/issues/255
 * @used-by ju_filter()
 * @used-by ju_map()
 * @used-by jua_select_ordered()
 * @used-by juak_transform()
 * @used-by \Justuno\Core\Qa\Dumper::dumpObject()
 * @param iterable $i
 */
function ju_ita($i):array {return is_array($i) ? $i : iterator_to_array($i);}

/**
 * 2020-06-14 "Port the `dfa_flatten` function": https://github.com/justuno-com/core/issues/17
 * http://stackoverflow.com/a/1320156
 * @used-by ju_cc()
 * @used-by ju_cc_n()
 * @used-by ju_cc_path()
 * @used-by ju_cc_s()
 * @used-by ju_ccc()
 * @used-by ju_contains()
 * @used-by ju_csv_pretty()
 * @used-by ju_explode_class_camel()
 * @used-by ju_explode_xpath()
 * @param array $a
 * @return mixed[]
 */
function jua_flatten(array $a):array {
	$r = []; /** @var mixed[] $r */
	array_walk_recursive($a, function($a) use(&$r) {$r[]= $a;});
	return $r;
}

/**
 * 2020-06-16 "Port the `dfaf` function": https://github.com/justuno-com/core/issues/32
 * @used-by ju_filter()
 * @used-by ju_find()
 * @used-by ju_map()
 * @used-by juak_transform()
 * @param array|callable|Traversable $a
 * @param array|callable|Traversable $b
 * @return array(int|string => mixed)
 */
function juaf($a, $b):array {
	# 2020-02-15
	# «A variable is expected to be a traversable or an array, but actually it is a «object»»:
	# https://github.com/tradefurniturecompany/site/issues/36
	$ca = is_callable($a); /** @var bool $ca */
	$cb = is_callable($b); /** @var bool $ca */
	if (!$ca || !$cb) {
		ju_assert($ca || $cb);
		$r = $ca ? [ju_assert_traversable($b), $a] : [ju_assert_traversable($a), $b];
	}
	else {
		$ta = is_iterable($a); /** @var bool $ta */
		$tb = is_iterable($b); /** @var bool $tb */
		if ($ta && $tb) {
			ju_error('juaf(): both arguments are callable and traversable: %s and %s.', ju_type($a), ju_type($b));
		}
		ju_assert($ta || $tb);
		$r = $ta ? [$a, $b] : [$b, $a];
	}
	return $r;
}

/**
 * 2021-01-28
 * @used-by \Justuno\M2\Store::v()
 * @param int|string $v
 * @param array(int|string => mixed) $map
 * @return int|string|mixed
 */
function jutr($v, array $map) {return jua($map, $v, $v);}