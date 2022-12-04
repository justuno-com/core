<?php
/**
 * 2020-08-19 "Port the `df_cc` function" https://github.com/justuno-com/core/issues/198
 * @see ju_ccc()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::frame()
 * @param string|string[] ...$a
 */
function ju_cc(string $glue, ...$a):string {return implode($glue, jua_flatten($a));}

/**
 * 2020-06-18 "Port the `df_cc_n` function": https://github.com/justuno-com/core/issues/63
 * @used-by ju_fe_init()
 * @used-by ju_kv()
 * @used-by ju_log_l()
 * @used-by ju_tab_multiline()
 * @used-by \Justuno\Core\Format\Html\Tag::content()
 * @used-by \Justuno\Core\Qa\Dumper::dumpArrayElements()
 * @used-by \Justuno\Core\Qa\Method::raiseErrorParam()
 * @used-by \Justuno\Core\Qa\Method::raiseErrorResult()
 * @used-by \Justuno\Core\Qa\Method::raiseErrorVariable()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::frame()
 * @param string|string[] ...$a
 */
function ju_cc_n(...$a):string {return ju_ccc("\n", jua_flatten($a));}

/**
 * 2020-06-21 "Port the `df_cc_path` function": https://github.com/justuno-com/core/issues/103
 * @used-by ju_cfg()
 * @used-by ju_file_name()
 * @used-by ju_js_x()
 * @used-by ju_module_path()
 * @used-by ju_module_path_etc()
 * @param string|string[] ...$args
 */
function ju_cc_path(...$args):string {return ju_ccc('/', jua_flatten($args));}

/**
 * 2016-08-10
 * 2020-08-21 "Port the `df_cc_s` function" https://github.com/justuno-com/core/issues/210
 * @used-by ju_cli_cmd()
 * @used-by \Justuno\Core\Format\Html\Tag::openTagWithAttributesAsText()
 * @param string|string[] ...$args
 */
function ju_cc_s(...$args):string {return ju_ccc(' ', jua_flatten($args));}

/**
 * 2020-06-18 "Port the `df_ccc` function": https://github.com/justuno-com/core/issues/57
 * @used-by ju_asset_name()
 * @used-by ju_cc_method()
 * @used-by ju_cc_n()
 * @used-by ju_cc_path()
 * @used-by ju_cc_s()
 * @used-by ju_fe_init()
 * @used-by ju_log_l()
 * @used-by \Justuno\Core\Qa\Message::reportName()
 * @used-by \Justuno\M2\Setup\UpgradeSchema::tr()
 * @param string|string[] ...$a
 */
function ju_ccc(string $glue, ...$a):string {return implode($glue, ju_clean(jua_flatten($a)));}