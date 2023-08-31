<?php
namespace Justuno\Core\Framework\Log;
use Justuno\Core\Cron\Model\LoggerHandler as CronH;
use Justuno\Core\Framework\Log\Handler\BrokenReference as BrokenReferenceH;
use Justuno\Core\Framework\Log\Handler\Cookie as CookieH;
use Justuno\Core\Framework\Log\Handler\JsMap as JsMapH;
use Justuno\Core\Framework\Log\Handler\NoSuchEntity as NoSuchEntityH;
use Justuno\Core\Framework\Log\Handler\PayPal as PayPalH;
use Magento\Framework\App\Bootstrap as B;
use Magento\Framework\DataObject as O;
use Magento\Framework\Logger\Handler\System as _P;
use Monolog\Logger as L;
use \Throwable as Th; # 2023-08-02 "Treat `\Throwable` similar to `\Exception`": https://github.com/mage2pro/core/issues/311
/**
 * 2019-10-13
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * 1) "Disable the logging of «Add of item with id %s was processed» messages to `system.log`":
 * https://github.com/kingpalm-com/core/issues/36
 * 2) @see \Magento\Backend\Model\Menu::add()
 * 3) It is impossible to write a plugin to any of this:
 * @see \Magento\Framework\Logger\Handler\System
 * @see \Magento\Framework\Logger\Handler\Base
 * @see \Monolog\Handler\AbstractProcessingHandle
 * @see \Psr\Log\LoggerInterface
 * It leads to the error: «Circular dependency:
 * Magento\Framework\Logger\Monolog depends on Magento\Framework\Cache\InvalidateLogger and vice versa.»
 * Magento 2 does not allow to write plugins to «objects that are instantiated
 * before @see \Magento\Framework\Interception is bootstrapped»:
 * https://devdocs.magento.com/guides/v2.3/extension-dev-guide/plugins.html#limitations
 * 2020-02-08
 * "The https://github.com/royalwholesalecandy/core/issues/57 solution works with Magento 2.2.5,
 * but does not work with Magento 2.3.2.":
 * https://github.com/tradefurniturecompany/core/issues/25#issuecomment-583734975
 * @see \Justuno\Core\Cron\Model\LoggerHandler
 * 2020-08-31 Despite of the name, this handler processes the messages of all levels by default (including exceptions).
 */
class Dispatcher extends _P {
	/**
	 * 2019-10-13
	 * 2021-21-21
	 * 1) "«Declaration of Justuno\Core\Framework\Log\Dispatcher::handle(array $d)
	 * must be compatible with Monolog\Handler\AbstractProcessingHandler::handle(array $record): bool» in Magento 2.4.3":
	 * https://github.com/mage2pro/core/issues/166
	 * 2) @see \Justuno\Core\Cron\Model\LoggerHandler::handle()
	 * @override
	 * @see \Monolog\Handler\AbstractProcessingHandler::handle()
	 * @param array(string => mixed) $d
	 */
	function handle(array $d):bool {
		$rc = new Record($d); /** @var Record $rc */
		if (
			!($r = BrokenReferenceH::p($rc)
			|| CronH::p($d)
			|| CookieH::p($rc)
			|| JsMapH::p($rc)
			|| NoSuchEntityH::p($rc)
			|| PayPalH::p($rc))
		) {
			# 2020-08-30
			# "Provide an ability to third-party modules to prevent a message to be logged to `system.log`":
			# https://github.com/mage2pro/core/issues/140
			# 2020-10-04
			# https://github.com/tradefurniturecompany/core/blob/0.3.1/etc/frontend/events.xml#L6-L12
			# https://github.com/tradefurniturecompany/core/blob/0.3.1/Observer/CanLog.php#L23-L34
			ju_dispatch('ju_can_log', [self::P_MESSAGE => $d, self::P_RESULT => ($o = new O)]); /** @var O $o */
			if (!($r = !!$o[self::V_SKIP])) {
				$e = ju_caller_entry(0, function(array $e) {return
					!($c = jua($e, 'class')) || !is_a($c, L::class, true) && !is_a($c, __CLASS__, true)
				;}); /** @var array(string => int) $e */
				$c = jua($e, 'class'); /** @var string|null c */
				$f = jua($e, 'function'); /** @var string|null $f */
				/**
				 * 2021-10-04
				 * 1) @see \Magento\Framework\App\Bootstrap::run():
				 *		$this->objectManager->get(LoggerInterface::class)->error($e->getMessage());
				 * It is handled in @see \Justuno\Core\Framework\Plugin\AppInterface::beforeCatchException()
				 * 2) "The backtrace is not logged for «no class registered for scheme» errors":
				 * https://github.com/mage2pro/core/issues/160
				 */
				if (B::class != $c || 'run' !== $f) {
					$ef = $rc->ef(); /** @var Th|null $ef */
					$args = [null, $ef ?: $d, $ef ? $rc->extra() : []]; /** @var mixed  $args */
					# 2023-07-25
					# I intentionally do not pass these messages to Sentry
					# because I afraid that they could be too numerous in some third-party websites.
					ju_log_l(...$args);
					# 2023-08-01
					# "`Justuno\Core\Framework\Log\Dispatcher::handle()` should pass to Sentry the records
					# with level ≥ `Monolog\Logger::ERROR` (`ERROR`, `CRITICAL`, `ALERT`, `EMERGENCY`)":
					# https://github.com/mage2pro/core/issues/304
					if (L::ERROR <= $rc->level()) {
						ju_sentry(...$args);
					}
				}
				$r = true; # 2020-09-24 The pevious code was: `$r = parent::handle($d);`
			}
		}
		return $r;
	}

	/**
	 * 2020-08-30
	 * "Provide an ability to third-party modules to prevent a message to be logged to `system.log`":
	 * https://github.com/mage2pro/core/issues/140
	 * @used-by self::handle()
	 */
	const P_MESSAGE = 'message';
	/**
	 * 2020-08-30
	 * "Provide an ability to third-party modules to prevent a message to be logged to `system.log`":
	 * https://github.com/mage2pro/core/issues/140
	 * @used-by self::handle()
	 */
	const P_RESULT = 'result';
	/**
	 * 2020-08-30
	 * "Provide an ability to third-party modules to prevent a message to be logged to `system.log`":
	 * https://github.com/mage2pro/core/issues/140
	 * @used-by self::handle()
	 */
	const V_SKIP = 'skip';
}