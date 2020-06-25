<?php
use Df\Core\Exception as DFE;
use Df\Sentry\Client as Sentry;
use Exception as E;
use Magento\Framework\DataObject as _DO;
use Magento\User\Model\User;
/**
 * 2016-12-22
 * $m could be:
 * 1) A module name: «A_B»
 * 2) A class name: «A\B\C».
 * 3) An object: it comes down to the case 2 via @see get_class()
 * 4) `null`: it comes down to the case 1 with the «Df_Core» module name.
 * 2020-06-24 "Port the `df_sentry` function": https://github.com/justuno-com/core/issues/118
 * @used-by ju_log()
 * @param string|object|null $m
 * @param _DO|mixed[]|mixed|E $v
 * @param array(string => mixed) $context [optional]
 */
function ju_sentry($m, $v, array $context = []) {
	static $domainsToSkip = []; /** @var string[] $domainsToSkip */
	if ($v instanceof E || !in_array(ju_domain_current(), $domainsToSkip)) {
		$m = ju_sentry_module($m);
		static $d; /** @var array(string => mixed) $d */
		$d = $d ?: ['extra' => [], 'fingerprint' => [
			ju_core_version(), ju_domain_current(), df_magento_version(), df_package_version($m), df_store_code()
		]];
		// 2017-01-09
		if ($v instanceof DFE) {
			$context = df_extend($context, $v->sentryContext());
		}
		$context = df_extend($d, $context);
		if ($v instanceof E) {
			// 2016-12-22 https://docs.sentry.io/clients/php/usage/#reporting-exceptions
			df_sentry_m($m)->captureException($v, $context);
		}
		else {
			$v = ju_dump($v);
			// 2016-12-22 https://docs.sentry.io/clients/php/usage/#reporting-other-errors
			df_sentry_m($m)->captureMessage($v, [], [
				'fingerprint' => array_merge(jua($context, 'fingerprint', []), [$v])
				,'level' => Sentry::DEBUG
			] + $context);
		}
	}
}

/**
 * 2017-03-15
 * 2020-06-25 "Port the `df_sentry_module` function": https://github.com/justuno-com/core/issues/137
 * @used-by ju_sentry()
 * @param string|object|null $m [optional]
 * @return string
 */
function ju_sentry_module($m = null) {return !$m ? 'Justuno_Core' : ju_module_name($m);}