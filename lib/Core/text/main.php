<?php
/**
 * 2020-06-13 "Port the `df_contains` function": https://github.com/justuno-com/core/issues/16
 * @used-by jua()
 * @used-by ju_error_create()
 * @param string $haystack
 * @param string|string[] ...$n
 * @return bool
 */
function ju_contains($haystack, ...$n) {/** @var bool $r */
	// 2017-07-10 This branch is exclusively for optimization.
	if (1 === count($n) && !is_array($n0 = $n[0])) {
		$r = false !== strpos($haystack, $n0);
	}
	else {
		$r = false;
		$n = jua_flatten($n);
		foreach ($n as $nItem) {/** @var string $nItem */
			if (false !== strpos($haystack, $nItem)) {
				$r = true;
				break;
			}
		}
	}
	return $r;
}