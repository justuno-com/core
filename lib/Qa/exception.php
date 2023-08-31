<?php
use Justuno\Core\Exception as DFE;
use Exception as X;
use Magento\Framework\Phrase as P;
use Throwable as T; # 2023-08-31 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401

/**
 * 2023-08-02
 * @see ju_is_x()
 * @used-by ju_bt()
 * @used-by ju_bt_inc()
 * @used-by ju_error_create()
 * @used-by ju_log()
 * @used-by ju_log_l()
 * @used-by ju_sentry()
 * @used-by ju_xts()
 * @used-by ju_xtsd()
 * @used-by \Justuno\Core\Exception::__construct()
 */
function ju_is_th($v):bool {return $v instanceof T;}

/**
 * 2023-08-02
 * @see ju_is_th()
 * @used-by ju_th2x()
 */
function ju_is_x($v):bool {return $v instanceof X;}

/**
 * 2023-08-03
 * @used-by \Justuno\Core\Exception::__construct()
 */
function ju_th2x(T $t):X {return ju_is_x($t) ? $t : new X(ju_xts($t), $t->getCode(), $t);}

/**
 * 2016-07-18
 * 2020-08-21 "Port the `df_ef` function" https://github.com/justuno-com/core/issues/208
 * @used-by \Justuno\Core\Framework\Log\Record::ef()
 * @used-by \Justuno\Core\Qa\Failure\Exception::trace()
 */
function ju_xf(T $e):T {while ($e->getPrevious()) {$e = $e->getPrevious();} return $e;}

/**
 * 2020-06-15 "Port the `df_ets` function": https://github.com/justuno-com/core/issues/24
 * @used-by ju_sprintf_strict()
 * @used-by ju_xml_parse()
 * @used-by \Justuno\Core\Exception::__construct()
 * @used-by \Justuno\Core\Qa\Failure\Exception::e()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @used-by \Justuno\Core\Sentry\Client::captureException()
 * @param T|P|string $e
 */
function ju_xts($t):string {return ju_adjust_paths_in_message(
	!ju_is_th($t) ? $t : ($t instanceof DFE ? $t->message() : $t->getMessage())
);}