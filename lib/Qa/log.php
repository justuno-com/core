<?php
use Justuno\Core\Qa\Message\Failure\Exception as QE;
use Exception as E;
use Magento\Framework\DataObject as _DO;

/**
 * 2017-01-11
 * 2020-06-17 "Port the `df_log_e` function": https://github.com/justuno-com/core/issues/50
 * @used-by ju_error()
 * @param E $e
 * @param string|object|null $m [optional]
 * @param string|mixed[] $d [optional]
 * @param string|bool|null $suf [optional]
 */
function ju_log_e($e, $m = null, $d = [], $suf = null) {ju_log_l($m, $e, $d, !is_null($suf) ? $suf : df_caller_f());}

/**
 * 2017-01-11
 * 2020-06-17 "Port the `df_log_l` function": https://github.com/justuno-com/core/issues/51
 * @used-by ju_log_e()
 * @param string|object|null $m
 * @param string|mixed[]|E $p2
 * @param string|mixed[]|E $p3 [optional]
 * @param string|bool|null $suf [optional]
 */
function ju_log_l($m, $p2, $p3 = [], $suf = null) {
	/** @var E|null $e */ /** @var array|string|mixed $d */ /** @var string|null $suf */
	list($e, $d, $suf) = $p2 instanceof E ? [$p2, $p3, $suf] : [null, $p2, $p3];
	$suf = $suf ?: df_caller_f();
	if (is_array($d)) {
		$d = df_extend($d, ['Mage2.PRO' =>
			['mage2pro/core' => df_core_version(), 'Magento' => df_magento_version(), 'PHP' => phpversion()]
			+ (df_is_cli()
				? ['Command' => df_cli_cmd()]
				: (
					['Referer' => df_referer(), 'URL' => df_current_url()]
					+ (!df_request_o()->isPost() ? [] : ['Post' => $_POST])
				)
			)
		]);
	}
	$d = !$d ? null : (is_string($d) ? $d : ju_json_encode($d));
	df_report(
		df_ccc('--', 'mage2.pro/' . df_ccc('-', df_report_prefix($m), '{date}--{time}'), $suf) .  '.log'
		,df_cc_n(
			$d
			,!$e ? null : ['EXCEPTION', QE::i([
				QE::P__EXCEPTION => $e, QE::P__REPORT_NAME_PREFIX => df_report_prefix($m), QE::P__SHOW_CODE_CONTEXT => false
			])->report(), "\n\n"]
			,df_bt_s(1)
		)
	);
}