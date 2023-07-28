<?php
use Exception as E;

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
 * @return E|int
 */
function ju_bt_inc($p, int $o = 1) {return is_array($p) || $p instanceof E ? $p : $o + $p;}