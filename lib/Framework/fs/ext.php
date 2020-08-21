<?php

/**
 * 2015-11-28 http://stackoverflow.com/a/10368236
 * 2020-06-21 "Port the `df_file_ext` function": https://github.com/justuno-com/core/issues/97
 * @used-by ju_file_ext_def()
 * @param string $f
 * @return string
 */
function ju_file_ext($f) {return pathinfo($f, PATHINFO_EXTENSION);}

/**
 * 2020-06-28
 * 2020-08-22 "Port the `df_file_ext_add` function" https://github.com/justuno-com/core/issues/240
 * @used-by ju_block()
 * @param string $f
 * @param string|null $ext
 * @return string
 */
function ju_file_ext_add($f, $ext) {return !$ext ? $f : ju_append($f, ".$ext");}

/**
 * 2018-07-06
 * 2020-06-21 "Port the `df_file_ext_def` function": https://github.com/justuno-com/core/issues/96
 * @used-by ju_report()
 * @param string $f
 * @param string $ext
 * @return string
 */
function ju_file_ext_def($f, $ext) {return ($e = ju_file_ext($f)) ? $f : ju_trim_right($f, '.') . ".$ext";}