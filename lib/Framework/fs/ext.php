<?php

/**
 * 2015-11-28 http://stackoverflow.com/a/10368236
 * 2020-06-21 "Port the `df_file_ext` function": https://github.com/justuno-com/core/issues/97
 * @used-by ju_asset_create()
 * @used-by ju_file_ext_def()
 */
function ju_file_ext(string $f):string {return pathinfo($f, PATHINFO_EXTENSION);}

/**
 * 2020-06-28
 * 2020-08-22 "Port the `df_file_ext_add` function" https://github.com/justuno-com/core/issues/240
 * @used-by ju_block()
 * @used-by ju_module_file()
 */
function ju_file_ext_add(string $f, string $ext = ''):string {return !$ext ? $f : ju_append($f, ".$ext");}

/**
 * 2018-07-06
 * 2020-06-21 "Port the `df_file_ext_def` function": https://github.com/justuno-com/core/issues/96
 * @used-by ju_report()
 */
function ju_file_ext_def(string $f, string $ext):string {return ju_file_ext($f) ? $f : ju_trim_right($f, '.') . ".$ext";}

/**
 * 2015-04-01
 * 2019-08-09
 * 1) `preg_replace('#\.[^.]*$#', '', $file)` preserves the full path.
 * 2) `pathinfo($file, PATHINFO_FILENAME)` (https://stackoverflow.com/a/22537165)
 * strips the full path and returns the base name only.
 * 2020-08-24 "Port the `df_strip_ext` function" https://github.com/justuno-com/core/issues/323
 * @used-by \Justuno\M2\Controller\Js::execute()
 */
function ju_strip_ext(string $s):string {return preg_replace('#\.[^.]*$#', '', $s);}