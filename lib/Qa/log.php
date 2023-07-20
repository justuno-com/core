<?php
use Justuno\Core\Qa\Failure\Exception as QE;
use Exception as E;
use Magento\Framework\DataObject as _DO;
/**
 * 2020-06-22 "Port the `df_log` function": https://github.com/justuno-com/core/issues/117
 * 2022-11-30 @deprecated It is unused.
 * @param _DO|mixed[]|mixed|E $v
 * @param string|object|null $m [optional]
 */
function ju_log($v, $m = null):void {ju_log_l($m, $v); ju_sentry($m, $v);}

/**
 * 2017-01-11
 * 2020-06-17 "Port the `df_log_e` function": https://github.com/justuno-com/core/issues/50
 * @used-by ju_error()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::frame()
 * @param string|object|null $m [optional]
 * @param string|mixed[] $d [optional]
 * @param string|bool|null $suf [optional]
 */
function ju_log_e(E $e, $m = null, $d = [], $suf = null):void {ju_log_l($m, $e, $d, !is_null($suf) ? $suf : ju_caller_f());}

/**
 * 2017-01-11
 * 2020-06-17 "Port the `df_log_l` function": https://github.com/justuno-com/core/issues/51
 * @used-by ju_caller_m()
 * @used-by ju_log()
 * @used-by ju_log_e()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::frame()
 * @used-by \Justuno\Core\Sentry\Client::send_http()
 * @param string|object|null $m
 * @param string|mixed[]|E $p2
 * @param string|mixed[]|E $p3 [optional]
 */
function ju_log_l($m, $p2, $p3 = [], string $p4 = ''):void {
	/** @var E|null $e */ /** @var array|string|mixed $d */ /** @var string $suf */ /** @var string $pref */
	list($e, $d, $suf, $pref) = $p2 instanceof E ? [$p2, $p3, $p4, ''] : [null, $p2, $p3, $p4];
	if (!$m && $e) {
		/** @var array(string => string) $en */
		$en = ju_caller_entry($e, function(array $e) {return ($c = jua($e, 'class')) && ju_module_enabled($c);});
		list($m, $suf) = [jua($en, 'class'), jua($en, 'function', 'exception')];
	}
	$suf = $suf ?: ju_caller_f();
	if (is_array($d)) {
		$d = ju_extend($d, ['Mage2.PRO' => ju_context()]);
	}
	$d = !$d ? null : (is_string($d) ? $d : ju_json_encode($d));
	ju_report(
		ju_ccc('--', 'mage2.pro/' . ju_ccc('-', ju_report_prefix($m, $pref), '{date}--{time}'), $suf) .  '.log'
		,ju_cc_n($d, !$e ? null : ['EXCEPTION', QE::i($e)->report(), "\n\n"], ju_bt_s(1))
	);
}

/**
 * 2017-04-03
 * 2018-07-06 The `$append` parameter has been added.
 * 2020-02-14 If $append is `true`, then $m will be written on a new line.
 * 2020-06-20 "Port the `df_report` function": https://github.com/justuno-com/core/issues/93
 * @used-by ju_bt_log()
 * @used-by ju_log_l()
 */
function ju_report(string $f, string $m, bool $append = false):void {
	if (!ju_es($m)) {
		$f = ju_file_ext_def($f, 'log');
		$p = BP . '/var/log'; /** @var string $p */
		ju_file_write($append ? "$p/$f" : ju_file_name($p, $f), $m, $append);
	}
}

/**
 * 2020-01-31
 * 2020-08-21 "Port the `df_report_prefix` function" https://github.com/justuno-com/core/issues/214
 * 2023-07-20
 * «mb_strtolower(): Passing null to parameter #1 ($string) of type string is deprecated
 * in vendor/mage2pro/core/Qa/lib/log.php on line 122»: https://github.com/mage2pro/core/issues/233
 * @used-by ju_log_l()
 * @param string|object|null $m [optional]
 */
function ju_report_prefix($m = null, string $pref = ''):string {return ju_ccc('--',
	mb_strtolower($pref), !$m ? null : ju_cts_lc_camel($m, '-')
);}