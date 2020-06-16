<?php
use Justuno\Core\Exception as DFE;
use Exception as E;
use Magento\Framework\Phrase;

/**
 * 2020-06-17 "Port the `df_error` function": https://github.com/justuno-com/core/issues/34
 * @param string ...$args
 * @throws DFE
 */
function ju_error(...$args) {
	ju_header_utf();
	$e = ju_error_create(...$args); /** @var DFE $e */
	/**
	 * 2020-02-15
	 * 1) "The Cron log (`magento.cron.log`) should contain a backtrace for every exception logged":
	 * https://github.com/tradefurniturecompany/site/issues/34
	 * 2) The @see \Exception 's backtrace is set when the exception is created, not when it is thrown:
	 * https://3v4l.org/qhd7m
	 * So we have a correct backtrace even without throwing the exception.
	 * 2020-02-17 @see \Df\Cron\Plugin\Console\Command\CronCommand::aroundRun()
	 */
	if (df_is_cron()) {
		df_log_e($e, 'Df_Cron');
	}
	throw $e;
}

/**
 * 2016-07-31
 * 2020-06-17 "Port the `df_error_create` function": https://github.com/justuno-com/core/issues/37
 * @used-by ju_error()
 * @used-by \Df\API\Client::_p()
 * @param string|string[]|mixed|E|Phrase|null $m [optional]
 * @return DFE
 */
function ju_error_create($m = null) {return
	$m instanceof E ? ju_ewrap($m) :
		new DFE($m instanceof Phrase ? $m : (
			/**
			 * 2019-12-16
			 * I have changed `!$m` to `is_null($m)`.
			 * It passes an empty string ('') directly to @uses \Df\Core\Exception::__construct()
			 * and it prevents @uses \Df\Core\Exception::__construct() from calling @see df_bt()
			 * @see \Df\Core\Exception::__construct():
			 *		if (is_null($m)) {
			 *			$m = __($prev ? df_ets($prev) : 'No message');
			 *			// 2017-02-20 To facilite the «No message» diagnostics.
			 *			if (!$prev) {
			 *				df_bt();
			 *			}
			 *		}
			 */
			is_null($m) ? null : (is_array($m) ? implode("\n\n", $m) : (
				ju_contains($m, '%1') ? __($m, ...ju_tail(func_get_args())) :
					ju_format(func_get_args())
			))
		))
;}