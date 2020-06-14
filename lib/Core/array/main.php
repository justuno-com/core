<?php
/**
 * 2020-06-14 "Port the `df_array` function": https://github.com/justuno-com/core/issues/21
 * @used-by ju_explode_xpath()
 * @param mixed|mixed[] $v
 * @return mixed[]|string[]|float[]|int[]
 */
function ju_array($v) {return is_array($v) ? $v : [$v];}

/**
 * 2020-06-13 "Port the `df_ita` function": https://github.com/justuno-com/core/issues/15
 * @param \Traversable|array $t
 * @return array
 */
function ju_ita($t) {return is_array($t) ? $t : iterator_to_array($t);}

/**
 * 2020-06-14 "Port the `dfa_flatten` function": https://github.com/justuno-com/core/issues/17
 * http://stackoverflow.com/a/1320156
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