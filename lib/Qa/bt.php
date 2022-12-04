<?php
use Exception as E;
use Justuno\Core\Qa\Trace;
use Justuno\Core\Qa\Trace\Formatter;

/**
 * 2021-10-04
 * @used-by ju_bt_s()
 * @used-by ju_caller_entry()
 * @used-by \Justuno\Core\Qa\Method::caller()
 * @param E|int|null|array(array(string => string|int)) $p [optional]
 * @return array(array(string => mixed))
 */
function ju_bt($p = 0, int $limit = 0):array {return is_array($p) ? $p : ($p instanceof E ? $p->getTrace() : ju_slice(
	debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, !$limit ? 0 : 1 + $p + $limit), 1 + $p, $limit
));}

/**
 * 2021-10-04
 * @used-by ju_bt_log()
 * @used-by ju_bt_s()
 * @used-by ju_caller_entry()
 * @param E|int|null|array(array(string => string|int)) $p
 * @param int $o [optional]
 * @return E|int
 */
function ju_bt_inc($p, $o = 1) {return is_array($p) || $p instanceof E ? $p : $o + $p;}

/**
 * 2020-06-16 "Port the `df_bt` function": https://github.com/justuno-com/core/issues/27
 * @param int|E|array(array(string => string|int)) $p
 * Позволяет при записи стека вызовов пропустить несколько последних вызовов функций,
 * которые и так очевидны (например, вызов данной функции, вызов df_bt_log() и т.п.)
 */
function ju_bt_log($p = 0):void {ju_report('bt-{date}-{time}.log', ju_bt_s(ju_bt_inc($p)));}

/**
 * 2020-06-16 "Port the `df_bt_s` function": https://github.com/justuno-com/core/issues/28
 * @used-by ju_bt_log()
 * @used-by ju_log_l()
 * @param int|E|array(array(string => string|int)) $p
 * Позволяет при записи стека вызовов пропустить несколько последних вызовов функций,
 * которые и так очевидны (например, вызов данной функции, вызов df_bt_log() и т.п.)
 */
function ju_bt_s($p = 0):string {return Formatter::p(new Trace(ju_bt(ju_bt_inc($p))));}