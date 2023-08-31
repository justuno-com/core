<?php
use Justuno\Core\Qa\Failure\Exception as QE;
use Magento\Framework\DataObject as _DO;
use Throwable as T; # 2023-08-31 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401
/**
 * 2020-06-22 "Port the `df_log` function": https://github.com/justuno-com/core/issues/117
 * @used-by ju_error()
 * @used-by \Justuno\Core\Framework\Plugin\AppInterface::beforeCatchException()
 * @used-by \Justuno\Core\Framework\Plugin\App\Response\HttpInterface::beforeSetBody()
 * @used-by \Justuno\Core\Qa\Failure\Error::log()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @param _DO|mixed[]|mixed|T $v
 * @param string|object|null $m [optional]
 */
function ju_log($v, $m = null, array $d = []):void {
	$isT = ju_is_th($v); /** @var bool $isT */
	$m = $m ? ju_module_name($m) : ($isT ? ju_caller_module($v) : ju_caller_module());
	ju_log_l($m, ...($isT ? [$v, $d] : [!$d ? $v : (jua_merge_r($d, is_array($v) ? $v : ['message' => $v])), []]));
	ju_sentry($m, ...($isT || !is_array($v) ? [$v, $d] : ['', jua_merge_r($d, $v)]));
}

/**
 * 2017-01-11
 * 2020-06-17 "Port the `df_log_l` function": https://github.com/justuno-com/core/issues/51
 * @used-by ju_caller_m()
 * @used-by ju_log()
 * @used-by \Justuno\Core\Cron\Model\LoggerHandler::p()
 * @used-by \Justuno\Core\Framework\Log\Dispatcher::handle()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @used-by \Justuno\Core\Sentry\Client::send_http()
 * @param string|object|null $m
 * @param string|mixed[]|T $p2
 * @param string|mixed[]|T $p3 [optional]
 */
function ju_log_l($m, $p2, $p3 = [], string $p4 = ''):void {
	/** @var T|null $t */ /** @var array|string|mixed $d */ /** @var string $suf */ /** @var string $pref */
	list($t, $d, $suf, $pref) = ju_is_th($p2) ? [$p2, $p3, $p4, ''] : [null, $p2, ju_ets($p3), $p4];
	$m = $m ?: ($t ? ju_caller_module($t) : ju_caller_module());
	if (!$suf) {
		# 2023-07-26
		# 1) "If `df_log_l()` is called from a `*.phtml`,
		# then the `*.phtml`'s base name  should be used as the log file name suffix instead of `df_log_l`":
		# https://github.com/mage2pro/core/issues/269
		# 2) 2023-07-26 "Add the `$skip` optional parameter to `df_caller_entry()`": https://github.com/mage2pro/core/issues/281
		$entry = $t ? ju_caller_entry_m($t) : ju_caller_entry(0, null, ['df_log']); /** @var array(string => string|int) $entry */
		$suf = ju_bt_entry_is_phtml($entry) ? basename(ju_bt_entry_file($entry)) : ju_bt_entry_func($entry);
	}
	$c = ju_context(); /** @var array(string => mixed) $c */
	ju_report(
		ju_ccc('--', 'mage2.pro/' . ju_ccc('-', ju_report_prefix($m, $pref), '{date}--{time}'), $suf) .  '.log'
		# 2023-07-26
		# "`df_log_l()` should use the exception's trace instead of `df_bt_s(1)` for exceptions":
		# https://github.com/mage2pro/core/issues/261
		,ju_cc_n(
			# 2023-07-28
			# "`df_log_l` does not log the context if the message is not an array":
			# https://github.com/mage2pro/core/issues/289
			/** @uses ju_dump_ds() */
			ju_map('ju_dump_ds', !$d ? [$c] : (is_array($d) ? [jua_merge_r($d, ['Mage2.PRO' => $c])] : [$d, $c]))
			,!$t ? '' : ['EXCEPTION', QE::i($t)->report(), "\n\n"]
			,($t ? null : "\n") . ju_bt_s($t ?: 1)
		)
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
	mb_strtolower($pref), !$m ? null : ju_module_name_lc($m, '-')
);}