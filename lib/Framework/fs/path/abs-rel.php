<?php
use Magento\Framework\App\Filesystem\DirectoryList as DL;

/**
 * 2020-06-15 "Port the `df_adjust_paths_in_message` function": https://github.com/justuno-com/core/issues/25
 * @used-by ju_xts()
 * @used-by \Justuno\Core\Qa\Failure\Error::msg()
 */
function ju_adjust_paths_in_message(string $m):string {
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
		$end += 4; # 2016-12-23 It is the length of the «.php» suffix.
		$m =
			mb_substr($m, 0, $begin)
			# 2016-12-23 I use `+ 1` to cut off a slash («/» or «\») after BP.
			. ju_path_n(mb_substr($m, $begin + $bpLen + 1, $end - $begin - $bpLen - 1))
			. mb_substr($m, $end)
		;
	} while(true);
	return $m;
}

/**
 * 2023-07-25 "`df_path_absolute()` is wrongly implemented": https://github.com/mage2pro/core/issues/270
 * @see ju_sys_path_abs()
 * @used-by ju_contents()
 */
function ju_path_abs(string $p):string {
	$bp = ju_path_n(BP);
	$p = ju_path_n($p);
	/** 2023-07-26 Similar to @see df_prepend() */
	return ju_starts_with($p, $bp) ? $p : ju_cc_path($bp, ju_trim_ds_left($p));
}

/**
 * 2017-05-08
 * 2020-08-13 "Port the `df_path_is_internal` function" https://github.com/justuno-com/core/issues/177
 * @used-by \Justuno\Core\Sentry\Trace::info()
 */
function ju_path_is_internal(string $p):bool {return ju_es($p) || ju_starts_with(ju_path_n($p), ju_path_n(BP));}

/**
 * 2015-12-06
 * It trims the ending «/».
 * @uses \Magento\Framework\Filesystem\Directory\Read::getAbsolutePath() produces a result with a trailing «/».
 * 2020-08-13 "Port the `df_path_relative` function" https://github.com/justuno-com/core/issues/174
 * @used-by ju_file_write()
 * @used-by \Justuno\Core\Qa\Failure\Error::preface()
 * @used-by \Justuno\Core\Qa\Trace\Frame::file()
 * @used-by \Justuno\Core\Sentry\Trace::info()
 */
function ju_path_relative(string $p, string $type = DL::ROOT):string {return ju_trim_text_left(
	ju_trim_ds_left(ju_path_n($p)), ju_trim_ds_left(ju_sys_reader($type)->getAbsolutePath())
);}