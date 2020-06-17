<?php
/**
 * 2020-06-14 "Port the `df_array` function": https://github.com/justuno-com/core/issues/21
 * @used-by ju_explode_xpath()
 * @used-by ju_find()
 * @used-by ju_map()
 * @param mixed|mixed[] $v
 * @return mixed[]|string[]|float[]|int[]
 */
function ju_array($v) {return is_array($v) ? $v : [$v];}

/**
 * 2020-06-13 "Port the `df_ita` function": https://github.com/justuno-com/core/issues/15
 * @used-by ju_filter()
 * @used-by ju_map()
 * @used-by jua_select_ordered()
 * @param \Traversable|array $t
 * @return array
 */
function ju_ita($t) {return is_array($t) ? $t : iterator_to_array($t);}

/**
 * 2020-06-14 "Port the `dfa_flatten` function": https://github.com/justuno-com/core/issues/17
 * http://stackoverflow.com/a/1320156
 * @used-by ju_ccc()
 * @used-by ju_contains()
 * @used-by ju_explode_xpath()
 * @param array $a
 * @return mixed[]
 */
function jua_flatten(array $a) {
	$r = []; /** @var mixed[] $r */
	array_walk_recursive($a, function($a) use(&$r) {$r[]= $a;});
	return $r;
}

/**
 * 2020-06-16 "Port the `dfaf` function": https://github.com/justuno-com/core/issues/32
 * @used-by ju_filter()
 * @used-by ju_find()
 * @used-by ju_map()
 * @param array|callable|\Traversable $a
 * @param array|callable|\Traversable $b
 * @return array(int|string => mixed)
 */
function juaf($a, $b) {
	// 2020-02-15
	// «A variable is expected to be a traversable or an array, but actually it is a «object»»:
	// https://github.com/tradefurniturecompany/site/issues/36
	$ca = is_callable($a); /** @var bool $ca */
	$cb = is_callable($b); /** @var bool $ca */
	if (!$ca || !$cb) {
		ju_assert($ca || $cb);
		$r = $ca ? [df_assert_traversable($b), $a] : [df_assert_traversable($a), $b];
	}
	else {
		$ta = df_check_traversable($a); /** @var bool $ta */
		$tb = df_check_traversable($b); /** @var bool $tb */
		if ($ta && $tb) {
			df_error('dfaf(): both arguments are callable and traversable: %s and %s.',
				df_type($a), df_type($b)
			);
		}
		ju_assert($ta || $tb);
		$r = $ta ? [$a, $b] : [$b, $a];
	}
	return $r;
}