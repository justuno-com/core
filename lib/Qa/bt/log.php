<?php
use Justuno\Core\Qa\Trace;
use Justuno\Core\Qa\Trace\Formatter;
use Throwable as Th; # 2023-08-31 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401

/**
 * 2020-06-16 "Port the `df_bt` function": https://github.com/justuno-com/core/issues/27
 * @param int|Th|array(array(string => string|int)) $p
 * Позволяет при записи стека вызовов пропустить несколько последних вызовов функций,
 * которые и так очевидны (например, вызов данной функции, вызов df_bt_log() и т.п.)
 */
function ju_bt_log($p = 0):void {ju_report('bt-{date}-{time}.log', ju_bt_s(ju_bt_inc($p)));}

/**
 * 2020-06-16 "Port the `df_bt_s` function": https://github.com/justuno-com/core/issues/28
 * @used-by ju_bt_log()
 * @used-by ju_log_l()
 * @param int|Th|array(array(string => string|int)) $p
 * Позволяет при записи стека вызовов пропустить несколько последних вызовов функций,
 * которые и так очевидны (например, вызов данной функции, вызов df_bt_log() и т.п.)
 */
function ju_bt_s($p = 0):string {return Formatter::p(new Trace(ju_bt(ju_bt_inc($p))));}