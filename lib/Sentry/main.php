<?php
use Exception as E;
use Justuno\Core\Exception as DFE;
use Justuno\Core\Qa\Trace\Frame;
use Justuno\Core\Sentry\Client as Sentry;
use Magento\Framework\DataObject as _DO;
use Magento\User\Model\User;
/**
 * 2016-12-22
 * $m could be:
 * 		1) A module name: «A_B»
 * 		2) A class name: «A\B\C».
 * 		3) An object: it comes down to the case 2 via @see get_class()
 * 		4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2020-06-24 "Port the `df_sentry` function": https://github.com/justuno-com/core/issues/118
 * @used-by ju_log()
 * @used-by \Justuno\M2\Controller\Response\Catalog::execute()
 * @used-by \Justuno\M2\Response::p()
 * @param string|object|null $m
 * @param _DO|mixed[]|mixed|E $v
 * @param array(string => mixed) $context [optional]
 */
function ju_sentry($m, $v, array $extra = []):void {
	static $domainsToSkip = []; /** @var string[] $domainsToSkip */
	if ($v instanceof E || !in_array(ju_domain_current(), $domainsToSkip)) {
        # 2020-09-09, 2023-07-25 We need `df_caller_module(1)` (I checked it) because it is nested inside `df_sentry_module()`.
		$m = ju_sentry_module($m ?: ju_caller_module(1));
		# 2016-22-22 https://docs.sentry.io/clients/php/usage/#optional-attributes
		# 2023-07-25
		# "Change the 3rd argument of `df_sentry` from `$context` to `$extra`": https://github.com/mage2pro/core/issues/249
		$context = [
			'extra' => $extra
			/**
			 * 2016-12-25
			 * Чтобы события разных магазинов не группировались вместе.
			 * https://docs.sentry.io/learn/rollups/#customize-grouping-with-fingerprints
			 * 2017-03-15
			 * Раньше здесь стоял код: 'fingerprint' => ['{{ default }}', df_domain_current()]
			 * https://github.com/mage2pro/core/blob/2.2.0/Sentry/lib/main.php#L38
			 * При этом коде уже игнорируемые события появлялись в журнале снова и не снова.
			 * Поэтому я решил отныне не использовать {{ default }},
			 * а строить fingerprint полностью самостоятельно.
			 *
			 * Осознанно не включаю в fingerprint текещий адрес запроса HTTP,
			 * потому что он может содержать всякие уникальные параметры в конце, например:
			 * https://<domain>/us/rest/us/V1/dfe-stripe/fab9c9a3bb3e745ca94eaeb7128692c9/place-order
			 *
			 * 2017-04-03
			 * Раньше в fingerprint включалось ещё:
			 * df_is_cli() ? df_hash_a(df_cli_argv()) : (df_is_rest() ? df_rest_action() : df_action_name())
			 * Решил больше это не включать: пока нет в этом необходимости.
			 */
			,'fingerprint' => [
				ju_core_version(), ju_domain_current(), ju_magento_version(), ju_package_version($m), ju_store_code()
			]
		];
		# 2017-01-09
		if ($v instanceof DFE) {
			$context = jua_merge_r($context, $v->sentryContext());
		}
		if ($v instanceof E) {
			# 2016-12-22 https://docs.sentry.io/clients/php/usage/#reporting-exceptions
			ju_sentry_m($m)->captureException($v, $context);
		}
		else {
			if ($v) {
				$v = ju_dump($v);
			}
			else {
				# 2023-07-30 If not pass a title, the Sentry will use the «<unlabeled event>» title.
				$f = Frame::i(ju_caller_entry(1, null, ['ju_log'])); /** @var Frame $f */
				$v = $f->isPHTML() ? ju_ccc(':', $f->file(), $f->line()) : "{$f->method()}()";
			}
			# 2017-04-16
			# Добавляем заголовок события к «fingerprint», потому что иначе сообщения с разными заголовками
			# (например: «Robokassa: action» и «[Robokassa] request») будут сливаться вместе.
			$context['fingerprint'][]= $v;
			/**
			 * 2016-12-23
			 * «The record severity. Defaults to error.»
			 * https://docs.sentry.io/clientdev/attributes/#optional-attributes
			 *
			 * @used-by \Justuno\Core\Sentry\Client::capture():
			 *	if (!isset($data['level'])) {
			 *		$data['level'] = self::ERROR;
			 *	}
			 * https://github.com/mage2pro/sentry/blob/1.6.4/lib/Raven/Client.php#L640-L642
			 * При использовании @see \Justuno\Core\Sentry\Client::DEBUG у сообщения в списке сообщений
			 * в интерфейсе Sentry не будет никакой метки.
			 * При использовании @see \Justuno\Core\Sentry\Client::INFO у сообщения в списке сообщений
			 * в интерфейсе Sentry будет синяя метка «Info».
			 */
			$context['level'] = Sentry::DEBUG;
			# 2016-12-22 https://docs.sentry.io/clients/php/usage/#reporting-other-errors
			ju_sentry_m($m)->captureMessage($v, $context);
		}
	}
}

/**
 * 2017-01-10
 * 1) It could be called as `df_sentry_extra(['a' => 'b'])` or df_sentry_extra('a', 'b').
 * 2) $m could be:
 * 2.1) A module name: «A_B»
 * 2.2) A class name: «A\B\C».
 * 2.3) An object: it comes down to the case 2 via @see get_class()
 * 2.4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2021-02-22
 * @used-by \Justuno\M2\Store::v()
 * @param string|object|null $m
 * @param mixed ...$v
 */
function ju_sentry_extra($m, ...$v):void {ju_sentry_m($m)->extra(!$v ? $v : (is_array($v[0]) ? $v[0] : [$v[0] => $v[1]]));}

/**
 * 2016-12-22
 * $m could be:
 * 		1) a module name: «A_B»
 * 		2) a class name: «A\B\C».
 * 		3) an object: it comes down to the case 2 via @see get_class()
 * 		4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2020-06-26 "Port the `df_sentry_m` function": https://github.com/justuno-com/core/issues/161
 * @used-by ju_sentry()
 * @used-by ju_sentry_extra()
 * @used-by ju_sentry_m()
 * @param string|object|null $m
 * @return Sentry
 */
function ju_sentry_m($m):Sentry {return jucf(function(string $m):Sentry {
	$r = null; /** @var Sentry $r */
	$isCore = 'Justuno_Core' === $m; /** @var bool $isCore */
	/** @var array(string => $r) $a */ /** @var array(string => string)|null $sa */
	if (($a = ju_module_json($m, 'df', false)) && ($sa = jua($a, 'sentry'))) {
		$r = new Sentry(intval($sa['id']), $sa['key1'], $sa['key2']);
		# 2016-12-23 https://docs.sentry.io/clientdev/interfaces/user
		/** @var User|null $u */
		$r->user((ju_is_cli() ? ['username' => ju_cli_user()] : (
			($u = ju_backend_user()) ? [
				'email' => $u->getEmail(), 'id' => $u->getId(), 'username' => $u->getUserName()
			] : (!ju_is_frontend() ? [] : (($c = ju_customer())
				? ['email' => $c->getEmail(), 'id' => $c->getId(), 'username' => $c->getName()]
				: ['id' => ju_customer_session_id()]
			))
		)) + ['ip_address' => ju_visitor_ip()], false);
		$r->tags(
			['Core' => ju_core_version(), 'Magento' => ju_magento_version(), 'MySQL' => ju_db_version(), 'PHP' => phpversion()]
			# 2023-07-15 "Improve diagnostic messages": https://github.com/JustunoCom/m2/issues/49
			+ ($isCore ? [] : ['Justuno' => ju_package_version('Justuno_M2'),  'Justuno API' => ju_api_version()])
		);
	}
	return $r ?: (!$isCore ? ju_sentry_m('Justuno_Core') : ju_error('Sentry settings for `Justuno_Core` are absent.'));
# 2020-09-09, 2023-07-25 We need `df_caller_module(2)` because it is nested inside `df_sentry_module()` and `dfcf`.
}, [ju_sentry_module($m ?: ju_caller_module(2))]);}

/**
 * 2017-03-15
 * 2020-06-25 "Port the `df_sentry_module` function": https://github.com/justuno-com/core/issues/137
 * @used-by ju_sentry()
 * @used-by ju_sentry_m()
 * @param string|object|null $m [optional]
 */
function ju_sentry_module($m = null):string {return !$m ? 'Justuno_Core' : ju_module_name($m);}