<?php
use Df\Core\Exception as DFE;

/**
 * 2020-06-17 "Port the `df_error` function": https://github.com/justuno-com/core/issues/34
 * @param string ...$args
 * @throws DFE
 */
function ju_error(...$args) {
	ju_header_utf();
	$e = df_error_create(...$args); /** @var DFE $e */
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