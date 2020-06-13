<?php
/**
 * 2020-06-13 "Port the `dfa` function": https://github.com/justuno-com/core/issues/12
 * @used-by ju_request()
 * @param array(int|string => mixed) $a
 * @param string|string[]|int|null $k
 * @param mixed|callable $d
 * @return mixed|null|array(string => mixed)
 */
function jua(array $a, $k, $d = null) {return
	is_null($k) ? $a : (is_array($k) ? dfa_select_ordered($a, $k) : (isset($a[$k]) ? $a[$k] : (
		df_contains($k, '/') ? dfa_deep($a, $k, $d) : df_call_if($d, $k)
	)))
;}