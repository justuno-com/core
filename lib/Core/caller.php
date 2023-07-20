<?php
use Closure as F;
use Exception as E;

/**
 * 2017-11-19
 * 2021-02-24
 * @used-by \Justuno\M2\Response::p()
 */
function ju_caller_c(int $o = 0):string {return ju_first(ju_explode_method(ju_caller_m(++$o)));}

/**
 * 2017-03-28 If the function is called from a closure, then it will go up through the stask until it leaves all closures.
 * 2020-08-19 "Port the `df_caller_entry` function" https://github.com/justuno-com/core/issues/207
 * @used-by ju_caller_f()
 * @used-by ju_caller_m()
 * @used-by ju_log_l()
 * @param E|int|null|array(array(string => string|int)) $p [optional]
 */
function ju_caller_entry($p = 0, F $predicate = null):array {
	/**
	 * 2018-04-24
	 * I do not understand why did I use `2 + $offset` here before.
	 * Maybe the @uses array_slice() was included in the backtrace in previous PHP versions (e.g. PHP 5.6)?
	 * array_slice() is not included in the backtrace in PHP 7.1.14 and in PHP 7.0.27
	 * (I have checked it in the both XDebug enabled and disabled cases).
	 * 2019-01-14
	 * It seems that we need `2 + $offset` because the stack contains:
	 * 1) the current function: df_caller_entry
	 * 2) the function who calls df_caller_entry: df_caller_f, df_caller_m, or \Df\Framework\Log\Dispatcher::handle
	 * 3) the function who calls df_caller_f, df_caller_m, or \Df\Framework\Log\Dispatcher::handle: it should be the result.
	 * So the offset is 2.
	 * The previous code failed the @see \Df\API\Facade::p() method in the inkifi.com store.
	 */
	$bt = ju_bt(ju_bt_inc($p, 2)); /** @var array(int => array(string => mixed)) $bt */
	while ($r = array_shift($bt)) {/** @var array(string => string|int)|null $r */
		$f = $r['function']; /** @var string $f */
		# 2017-03-28
		# Надо использовать именно df_contains(),
		# потому что PHP 7 возвращает просто строку «{closure}», а PHP 5.6 и HHVM — «A::{closure}»: https://3v4l.org/lHmqk
		# 2020-09-24 I added "unknown" to evaluate expressions in IntelliJ IDEA's with xDebug.
		if (!ju_contains($f, '{closure}') && !in_array($f, ['juc', 'jucf', 'unknown']) && (!$predicate || $predicate($r))) {
			break;
		}
	}
	return ju_eta($r); /** 2021-10-05 @uses array_shift() returns `null` for an empty array */
}

/**
 * 2016-08-10
 * The original (not used now) implementation: https://github.com/mage2pro/core/blob/6.7.3/Core/lib/caller.php#L109-L111
 * 2017-01-12
 * The df_caller_ff() implementation: https://github.com/mage2pro/core/blob/6.7.3/Core/lib/caller.php#L113-L123
 * 2020-07-08 The function's new implementation is from the previous df_caller_ff() function.
 * 2020-08-19 "Port the `df_caller_f` function" https://github.com/justuno-com/core/issues/206
 * @used-by ju_log_e()
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
 * @used-by ju_caller_c()
 * @used-by ju_prop()
 */
function ju_caller_m(int $o = 0):string {
	$bt = ju_caller_entry(++$o); /** @var array(string => int) $bt */
	$class = jua($bt, 'class'); /** @var string $class */
	if (!$class) {
		ju_log_l(null, $m = "ju_caller_m(): no class.\nbt is:\n$bt", __FUNCTION__); /** @var string $m */
		ju_error($m);
	}
	return "$class::{$bt['function']}";
}