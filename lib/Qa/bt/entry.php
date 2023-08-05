<?php
/**
 * 2023-08-05
 * @see \Justuno\Core\Qa\Trace\Frame::class_()
 * @used-by df_caller_module()
 */
function ju_bt_entry_class(array $e):string {return jua($e, 'class', '');}

/**
 * 2023-07-26 "Implement `df_bt_entry_file()`": https://github.com/mage2pro/core/issues/279
 * @see \Justuno\Core\Qa\Trace\Frame::file()
 * @see \Justuno\Core\Sentry\Trace::info()
 * @used-by ju_bt()
 * @used-by ju_log_l()
 * @used-by ju_bt_entry_is_phtml()
 * @used-by ju_caller_module()
 * @used-by \Justuno\Core\Qa\Trace::__construct()
 * @used-by \Justuno\Core\Sentry\Trace::info()
 */
function ju_bt_entry_file(array $e):string {return
	/**
	 * 2023-01-28
	 * 1) The 'file' key can be absent in a stack frame, e.g.:
	 *	{
	 *		"function": "loadClass",
	 *		"class": "Composer\\Autoload\\ClassLoader",
	 *		"type": "->",
	 *		"args": ["Df\\Framework\\Plugin\\App\\Router\\ActionList\\Interceptor"]
	 *	},
	 *	{
	 *		"function": "spl_autoload_call",
	 *		"args": ["Df\\Framework\\Plugin\\App\\Router\\ActionList\\Interceptor"]
	 *	},
	 * 2) «Argument 1 passed to df_starts_with() must be of the type string, null given,
	 * called in vendor/mage2pro/core/Qa/Trace.php on line 28»: https://github.com/mage2pro/core/issues/186
	 * 3) @see \Justuno\Core\Qa\Trace\Frame::file()
	 */
	jua($e, 'file', '')
;}

/**
 * 2023-07-28
 * @see \Justuno\Core\Qa\Trace\Frame::function_()
 * @used-by ju_log_l()
 */
function ju_bt_entry_func(array $e):string {return jua($e, 'function', '');}

/**
 * 2023-07-27 `line` is absent in @see call_user_func() calls.
 * @see \Justuno\Core\Qa\Trace\Frame::line()
 * @used-by ju_bt()
 */
function ju_bt_entry_line(array $e):int {return jua($e, 'line', 0);}

/**
 * 2023-07-26
 * @used-by ju_caller_m()
 * @used-by ju_caller_module()
 */
function ju_bt_entry_is_method(array $e):bool {return jua_has_keys($e, ['class', 'function']);}

/**
 * 2023-07-26
 * @see \Justuno\Core\Qa\Trace\Frame::isPHTML()
 * @used-by ju_caller_module()
 * @used-by ju_log_l()
 */
function ju_bt_entry_is_phtml(array $e):bool {return ju_ends_with(ju_bt_entry_file($e), '.phtml');}