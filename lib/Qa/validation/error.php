<?php
use Justuno\Core\Exception as DFE;
use Magento\Framework\Phrase;
use Throwable as Th; # 2023-08-31 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401

/**
 * 2020-06-17 "Port the `df_error` function": https://github.com/justuno-com/core/issues/34
 * @used-by ju_assert()
 * @used-by ju_assert_eq()
 * @used-by ju_assert_gd()
 * @used-by ju_assert_ge()
 * @used-by ju_assert_gt0()
 * @used-by ju_assert_lt()
 * @used-by ju_assert_ne()
 * @used-by ju_assert_traversable()
 * @used-by ju_caller_m()
 * @used-by ju_customer()
 * @used-by ju_date_from_db()
 * @used-by ju_file_name()
 * @used-by ju_int()
 * @used-by ju_json_decode()
 * @used-by ju_module_file()
 * @used-by ju_oqi_is_leaf()
 * @used-by ju_oqi_qty()
 * @used-by ju_oqi_qty()
 * @used-by ju_order_last()
 * @used-by ju_pad()
 * @used-by ju_product_current()
 * @used-by ju_sentry_m()
 * @used-by ju_sprintf_strict()
 * @used-by ju_string()
 * @used-by ju_try()
 * @used-by ju_xml_parse()
 * @used-by juaf()
 * @used-by juc()
 * @used-by \Justuno\Core\Helper\Text::quote()
 * @used-by \Justuno\Core\Qa\Method::throwException()
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodParameter()
 * @used-by \Justuno\Core\Zf\Validate\IntT::filter()
 * @used-by \Justuno\M2\Catalog\Diagnostic::p()
 * @used-by \Justuno\M2\Controller\Cart\Add::product()
 * @used-by \Justuno\M2\Store::v()
 * @param string|string[]|mixed|Th|Phrase|null ...$a
 * @throws DFE
 */
function ju_error(...$a):void {
	ju_header_utf();
	$e = ju_error_create(...$a); /** @var DFE $e */
	/**
	 * 2020-02-15
	 * 1) "The Cron log (`magento.cron.log`) should contain a backtrace for every exception logged":
	 * https://github.com/tradefurniturecompany/site/issues/34
	 * 2) The @see \Exception 's backtrace is set when the exception is created, not when it is thrown:
	 * https://3v4l.org/qhd7m
	 * So we have a correct backtrace even without throwing the exception.
	 * 2020-02-17 @see \Justuno\Core\Cron\Plugin\Console\Command\CronCommand::aroundRun()
	 */
	if (ju_is_cron()) {
		ju_log($e);
	}
	throw $e;
}

/**
 * 2016-07-31
 * 2020-06-17 "Port the `df_error_create` function": https://github.com/justuno-com/core/issues/37
 * @used-by ju_error()
 * @param string|string[]|mixed|Th|Phrase|null $m [optional]
 */
function ju_error_create($m = null):DFE {return ju_is_th($m) ? DFE::wrap($m) :
	new DFE($m instanceof Phrase ? $m : (
		/**
		 * 2019-12-16
		 * I have changed `!$m` to `is_null($m)`.
		 * It passes an empty string ('') directly to @uses \Justuno\Core\Exception::__construct()
		 * and it prevents @uses \Justuno\Core\Exception::__construct() from calling @see ju_bt_log()
		 * @see \Justuno\Core\Exception::__construct():
		 *		if (is_null($m)) {
		 *			$m = __($prev ? ju_xts($prev) : 'No message');
		 *			# 2017-02-20 To facilite the «No message» diagnostics.
		 *			if (!$prev) {
		 *				ju_bt_log();
		 *			}
		 *		}
		 */
		is_null($m) ? null : (is_array($m) ? implode("\n\n", $m) : (
			ju_contains($m, '%1') ? __($m, ...ju_tail(func_get_args())) :
				ju_format(func_get_args())
		))
	))
;}