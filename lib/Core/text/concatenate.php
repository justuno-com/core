<?php
/**
 * 2020-08-19 "Port the `df_cc` function" https://github.com/justuno-com/core/issues/198
 * 2022-11-26 We can not declare the argument as `string ...$a` because such a syntax will reject arrays: https://3v4l.org/jFdPm
 * @see ju_ccc()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @param string|string[] ...$a
 */
function ju_cc(string $glue, ...$a):string {return implode($glue, jua_flatten($a));}

/**
 * 2020-06-18 "Port the `df_cc_n` function": https://github.com/justuno-com/core/issues/63
 * 2022-11-26 We can not declare the argument as `string ...$a` because such a syntax will reject arrays: https://3v4l.org/jFdPm
 * @used-by ju_fe_init()
 * @used-by ju_kv()
 * @used-by ju_log_l()
 * @used-by ju_tab_multiline()
 * @used-by \Justuno\Core\Html\Tag::content()
 * @used-by \Justuno\Core\Qa\Dumper::dumpArrayElements()
 * @used-by \Justuno\Core\Qa\Method::raiseErrorParam()
 * @used-by \Justuno\Core\Qa\Method::raiseErrorResult()
 * @used-by \Justuno\Core\Qa\Method::raiseErrorVariable()
 * @param string|string[] ...$a
 */
function ju_cc_n(...$a):string {return ju_ccc("\n", jua_flatten($a));}

/**
 * 2015-12-01 Отныне всегда используем / вместо DIRECTORY_SEPARATOR.
 * 2020-06-21 "Port the `df_cc_path` function": https://github.com/justuno-com/core/issues/103
 * 2022-11-26 We can not declare the argument as `string ...$a` because such a syntax will reject arrays: https://3v4l.org/jFdPm
 * @used-by ju_cfg()
 * @used-by ju_file_name()
 * @used-by ju_js_x()
 * @used-by ju_module_path()
 * @used-by ju_module_path_etc()
 * @used-by ju_path_abs()
 * @used-by \Justuno\Core\Qa\Trace\Frame::url()
 * @param string|string[] ...$a
 */
function ju_cc_path(...$a):string {return ju_ccc('/', jua_flatten($a));}

/**
 * 2016-08-10
 * 2020-08-21 "Port the `df_cc_s` function" https://github.com/justuno-com/core/issues/210
 * 2022-11-26 We can not declare the argument as `string ...$a` because such a syntax will reject arrays: https://3v4l.org/jFdPm
 * @used-by ju_cli_cmd()
 * @used-by \Justuno\Core\Html\Tag::openTagWithAttributesAsText()
 * @param string|string[] ...$a
 */
function ju_cc_s(...$a):string {return ju_ccc(' ', jua_flatten($a));}

/**
 * 2020-06-18 "Port the `df_ccc` function": https://github.com/justuno-com/core/issues/57
 * 2022-11-26 We can not declare the argument as `string ...$a` because such a syntax will reject arrays: https://3v4l.org/jFdPm
 * @used-by ju_asset_name()
 * @used-by ju_cc_method()
 * @used-by ju_cc_n()
 * @used-by ju_cc_path()
 * @used-by ju_cc_s()
 * @used-by ju_fe_init()
 * @used-by ju_log_l()
 * @used-by ju_sentry()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @used-by \Justuno\M2\Setup\UpgradeSchema::tr()
 * @param string|string[] ...$a
 */
function ju_ccc(string $glue, ...$a):string {return implode($glue, ju_clean(jua_flatten($a)));}