<?php

/**
 * 2020-06-20 "Port the `df_trim` function": https://github.com/justuno-com/core/issues/88
 * @used-by ju_explode_n()
 * @used-by ju_trim()
 * @used-by \Justuno\Core\Qa\Message::sections()
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
		/** @var \Justuno\Core\Zf\Filter\StringTrim $filter */
		$filter = new \Justuno\Core\Zf\Filter\StringTrim($charlist);
		$r = $filter->filter($s);
		$r = ju_nts($r);
		if (' ' === $r) {
			$r = '';
		}
	}
	return $r;
}, false === $throw ? $s : $throw);}

/**
 * 2017-08-18 Today I have noticed that $charlist = null does not work for @uses rtrim()
 * 2020-06-21 "Port the `df_trim_right` function": https://github.com/justuno-com/core/issues/98
 * @used-by ju_file_ext_def()
 * @param string $s
 * @param string $charlist [optional]
 * @return string
 */
function ju_trim_right($s, $charlist = null) {return rtrim($s, $charlist ?: " \t\n\r\0\x0B");}

/**
 * 2020-06-24 "Port the `df_trim_text_left` function": https://github.com/justuno-com/core/issues/135
 * @used-by ju_domain()
 * @param string $s
 * @param string|string[] $trim
 * @return string
 */
function ju_trim_text_left($s, $trim) {return is_array($trim) ? df_trim_text_a($s, $trim, __FUNCTION__) : (
	$trim === mb_substr($s, 0, $l = mb_strlen($trim)) ? mb_substr($s, $l) : $s
);}