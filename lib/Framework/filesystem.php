<?php
/**
 * 2020-06-15 "Port the `df_adjust_paths_in_message` function": https://github.com/justuno-com/core/issues/25
 * @used-by ju_ets()
 * @param string $m
 * @return string
 */
function ju_adjust_paths_in_message($m) {
	$bpLen = mb_strlen(BP); /** @var int $bpLen */
	do {
		$begin = mb_strpos($m, BP); /** @var int|false $begin */
		if (false === $begin) {
			break;
		}
		$end = mb_strpos($m, '.php', $begin + $bpLen); /** @var int|false $end */
		if (false === $end) {
			break;
		}
		$end += 4; // 2016-12-23 It is the length of the «.php» suffix.
		$m =
			mb_substr($m, 0, $begin)
			// 2016-12-23 I use `+ 1` to cut off a slash («/» or «\») after BP.
			. ju_path_n(mb_substr($m, $begin + $bpLen + 1, $end - $begin - $bpLen - 1))
			. mb_substr($m, $end)
		;
	} while(true);
	return $m;
}

/**
 * 2015-11-28 http://stackoverflow.com/a/10368236
 * 2020-06-21 "Port the `df_file_ext` function": https://github.com/justuno-com/core/issues/97
 * @used-by ju_file_ext_def()
 * @param string $f
 * @return string
 */
function ju_file_ext($f) {return pathinfo($f, PATHINFO_EXTENSION);}

/**
 * 2018-07-06
 * 2020-06-21 "Port the `df_file_ext_def` function": https://github.com/justuno-com/core/issues/96
 * @used-by ju_report()
 * @param string $f
 * @param string $ext
 * @return string
 */
function ju_file_ext_def($f, $ext) {return ($e = ju_file_ext($f)) ? $f : df_trim_right($f, '.') . ".$ext";}

/**
 * 2020-06-15 "Port the `df_path_n` function": https://github.com/justuno-com/core/issues/26
 * @used-by ju_adjust_paths_in_message()
 * @param string $p
 * @return string
 */
function ju_path_n($p) {return str_replace('//', '/', str_replace('\\', '/', $p));}