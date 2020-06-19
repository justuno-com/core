<?php

/**
 * 2020-06-20 "Port the `df_trim` function": https://github.com/justuno-com/core/issues/88
 * @used-by ju_explode_n()
 * @used-by ju_trim()
 * @param string|string[] $s
 * @param string $charlist [optional]
 * @param bool|mixed|\Closure $throw [optional]
 * @return string|string[]
 */
function ju_trim($s, $charlist = null, $throw = false) {return ju_try(function() use($s, $charlist, $throw) {
	/** @var string|string[] $r */
	if (is_array($s)) {
		$r = ju_map('ju_trim', $s, [$charlist, $throw]);
	}
	else {
		if (!is_null($charlist)) {
			/** @var string[] $addionalSymbolsToTrim */
			$addionalSymbolsToTrim = ["\n", "\r", ' '];
			foreach ($addionalSymbolsToTrim as $addionalSymbolToTrim) {
				/** @var string $addionalSymbolToTrim */
				if (!ju_contains($charlist, $addionalSymbolToTrim)) {
					$charlist .= $addionalSymbolToTrim;
				}
			}
		}
		/** @var \Df\Zf\Filter\StringTrim $filter */
		$filter = new \Df\Zf\Filter\StringTrim($charlist);
		$r = $filter->filter($s);
		$r = ju_nts($r);
		if (' ' === $r) {
			$r = '';
		}
	}
	return $r;
}, false === $throw ? $s : $throw);}