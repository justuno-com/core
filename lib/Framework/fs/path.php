<?php
use Magento\Framework\App\Filesystem\DirectoryList as DL;

/**
 * 2017-05-08
 * 2020-08-13 "Port the `df_path_is_internal` function" https://github.com/justuno-com/core/issues/177
 * @used-by \Justuno\Core\Sentry\Trace::info()
 */
function ju_path_is_internal(string $p):bool {return '' === $p || ju_starts_with(ju_path_n($p), ju_path_n(BP));}

/**
 * 2020-06-15 "Port the `df_path_n` function": https://github.com/justuno-com/core/issues/26
 * @used-by ju_adjust_paths_in_message()
 * @used-by ju_file_name()
 * @used-by ju_path_abs()
 * @used-by ju_path_is_internal()
 * @used-by ju_path_relative()
 */
function ju_path_n(string $p):string {return str_replace('//', '/', str_replace('\\', '/', $p));}

/**
 * 2015-12-06
 * It trims the ending «/».
 * @uses \Magento\Framework\Filesystem\Directory\Read::getAbsolutePath() produces a result with a trailing «/».
 * 2020-08-13 "Port the `df_path_relative` function" https://github.com/justuno-com/core/issues/174
 * @used-by ju_file_write()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::frame()
 * @used-by \Justuno\Core\Sentry\Trace::info()
 */
function ju_path_relative(string $p, string $b = DL::ROOT):string {return ju_trim_text_left(ju_trim_ds_left(
	ju_path_n($p)), ju_trim_ds_left(ju_fs_r($b)->getAbsolutePath()
));}