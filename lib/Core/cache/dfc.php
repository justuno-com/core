<?php
use Justuno\Core\RAM;

/**
 * 2016-08-31
 * 2020-08-14 "Port the `dfc` function" https://github.com/justuno-com/core/issues/194
 * 2022-11-17
 * `object` as an argument type is not supported by PHP < 7.2: https://github.com/mage2pro/core/issues/174#user-content-object
 * @used-by \Justuno\Core\Config\Source::pathA()
 * @used-by \Justuno\Core\Html\Tag::content()
 * @used-by \Justuno\Core\Html\Tag::shouldAttributesBeMultiline()
 * @used-by \Justuno\Core\Html\Tag::tag()
 * @used-by \Justuno\Core\Qa\Failure::report()
 * @used-by \Justuno\Core\Qa\Failure\Exception::e()
 * @used-by \Justuno\Core\Qa\Trace\Frame::file()
 * @used-by \Justuno\Core\Qa\Trace\Frame::functionA()
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodParameter()
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodR()
 * @used-by \Justuno\Core\Qa\Trace\Frame::url()
 * @param object $o
 * @return mixed
 */
function juc($o, Closure $f, array $a = [], bool $unique = true, int $offset = 0) {
	/**
	 * 2021-10-05
	 * I do not use @see ju_bt() to make the implementation faster. An implementation via ju_bt() is:
	 * 		$b = ju_bt(0, 2 + $offset)[1 + $offset];
	 */
	$b = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2 + $offset)[1 + $offset]; /** @var array(string => string) $b */
	if (!isset($b['class'], $b['function'])) {
		ju_error("[juc] Invalid backtrace frame:\n" . ju_dump($b)); # 2017-01-02 Usually it means that $offset is wrong.
	}
	/** @var string $k */
	$k = "{$b['class']}::{$b['function']}" . (!$a ? null : ju_hash_a($a)) . ($unique ? null : spl_object_hash($f));
	/**
	 * 2022-10-17
	 * 1) Dynamic properties are deprecated since PHP 8.2:
	 * https://php.net/manual/migration82.deprecated.php#migration82.deprecated.core.dynamic-properties
	 * https://wiki.php.net/rfc/deprecate_dynamic_properties
	 * 2) @see ju_prop_k()
	 * @var mixed $r
	 */
	static $hasWeakMap; /** @var bool $hasWeakMap */
	if (!($hasWeakMap = !is_null($hasWeakMap) ? $hasWeakMap : @class_exists('WeakMap'))) {
		# 2017-01-12 ... works correctly here: https://3v4l.org/0shto
		# 2022-10-17 The ternary operator works correctly here: https://3v4l.org/MutM4
		/** @noinspection PhpVariableVariableInspection */
		$r = property_exists($o, $k) ? $o->$k : $o->$k = $f(...$a);
	}
	else {
		static $map; /** @var WeakMap $map */
		$map = $map ?: new WeakMap;
		if (!$map->offsetExists($o)) {
			$map[$o] = [];
		}
		# 2022-10-17 https://3v4l.org/6cVAu
		$map2 =& $map[$o]; /** @var array(string => mixed) $map2 */
		/**
		 * 2017-01-12 ... works correctly here: https://3v4l.org/0shto
		 * 2022-10-17 The ternary operator works correctly here: https://3v4l.org/MutM4
		 * 2022-10-27 We can not use @see isset() here: https://3v4l.org/FhAUv
		 * 2022-10-28 @see \Justuno\Core\RAM::exists()
		 */
		$r = array_key_exists($k, $map2) ? $map2[$k] : $map2[$k] = $f(...$a);
	}
	return $r;
}

/**
 * 2020-06-13 "Port the `dfcf` function": https://github.com/justuno-com/core/issues/5
 * @used-by ju_asset_exists()
 * @used-by ju_cli_user()
 * @used-by ju_core_version()
 * @used-by ju_db_version()
 * @used-by ju_domain_current()
 * @used-by ju_magento_version()
 * @used-by ju_module_file_read()
 * @used-by ju_module_name()
 * @used-by ju_msi()
 * @used-by ju_msi_website2stockId()
 * @used-by ju_my_local()
 * @used-by ju_o()
 * @used-by ju_sentry_m()
 * @used-by ju_table()
 * @used-by \Justuno\Core\Config\Settings::s()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @used-by \Justuno\M2\Store::v()
 * @param string[] $tags [optional]
 * @return mixed
 */
function jucf(Closure $f, array $a = [], array $tags = [], bool $unique = true, int $offset = 0) {
	$b = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2 + $offset)[1 + $offset]; /** @var array(string => string) $b */
	/** @var string $k */
	$k = (!isset($b['class']) ? null : $b['class'] . '::') . $b['function']
		. (!$a ? null : '--' . ju_hash_a($a))
		. ($unique ? null : '--' . spl_object_hash($f))
	;
	$r = ju_ram(); /** @var RAM $r */
	# 2017-01-12
	# The following code will return `3`:
	# 		$a = function($a, $b) {return $a + $b;};
	# 		$b = [1, 2];
	# 		echo $a(...$b);
	# https://3v4l.org/0shto
	return $r->exists($k) ? $r->get($k) : $r->set($k, $f(...$a), $tags);
}