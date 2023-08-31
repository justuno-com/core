<?php
/**
 * 2017-11-19
 * 2021-02-24
 * @used-by \Justuno\M2\Response::p()
 */
function ju_caller_c(int $o = 0):string {return ju_first(ju_explode_method(ju_caller_m(++$o)));}

/**
 * 2016-08-10
 * The original (not used now) implementation: https://github.com/mage2pro/core/blob/6.7.3/Core/lib/caller.php#L109-L111
 * 2017-01-12
 * The df_caller_ff() implementation: https://github.com/mage2pro/core/blob/6.7.3/Core/lib/caller.php#L113-L123
 * 2020-07-08 The function's new implementation is from the previous df_caller_ff() function.
 * 2020-08-19 "Port the `df_caller_f` function" https://github.com/justuno-com/core/issues/206
 * @used-by ju_log_l()
 * @used-by ju_oqi_amount()
 * @used-by ju_prop()
 * @used-by \Justuno\Core\Config\Settings::v()
 */
function ju_caller_f(int $o = 0):string {return ju_caller_entry(++$o)['function'];}

/**
 * 2016-08-10
 * The original (not used now) implementation: https://github.com/mage2pro/core/blob/6.7.3/Core/lib/caller.php#L125-L136
 * 2017-03-28
 * The df_caller_mm() implementation: https://github.com/mage2pro/core/blob/6.7.3/Core/lib/caller.php#L155-L169
 * 2020-07-08 The function's new implementation is from the previous df_caller_mm() function.
 * 2020-08-19 "Port the `df_caller_m` function" https://github.com/justuno-com/core/issues/205
 * 2023-07-26
 *  1) «Array to string conversion in vendor/mage2pro/core/Core/lib/caller.php on line 114»
 *  https://github.com/mage2pro/core/issues/257
 *  2) The pevious error handling never worked correctly:
 *  https://github.com/mage2pro/core/tree/9.8.4/Core/lib/caller.php#L114
 * @used-by ju_caller_c()
 * @used-by ju_prop()
 */
function ju_caller_m(int $o = 0):string {return ju_cc_method(ju_assert(ju_caller_entry(++$o,
	# 2023-07-26
	# "«The required key «class» is absent» is `df_log()` is called from `*.phtml`":
	# https://github.com/mage2pro/core/issues/259
	'ju_bt_entry_is_method' /** @uses ju_bt_entry_is_method() */
)));}

/**
 * 2023-07-25
 * 2023-07-26
 * The previous implementation:
 * 		return df_module_name(df_caller_c(++$o))
 * https://github.com/mage2pro/core/blob/9.9.5/Core/lib/caller.php#L147
 * @used-by ju_log()
 * @used-by ju_log_l()
 * @used-by ju_sentry()
 * @used-by ju_sentry_m()
 */
function ju_caller_module($p = 0):string {return !($e = ju_caller_entry_m(ju_bt_inc($p))) ? 'Justuno_Core' : (
	# 2023-08-05 «Module 'Monolog_Logger::addRecord' is not correctly registered»: https://github.com/mage2pro/core/issues/317
	ju_bt_entry_is_method($e) ? ju_module_name(ju_bt_entry_class($e)) : ju_module_name_by_path(ju_bt_entry_file($e))
);}