<?php
/**
 * 2019-09-08
 * 2020-08-19 "Port the `df_prop` function" https://github.com/justuno-com/core/issues/204
 * @used-by ju_prop()
 * @used-by \Justuno\Core\Zf\Validate::v()
 */
const JU_N = 'df-null';

/**
 * 2019-04-05
 * 2019-09-08 Now it supports static properties.
 * 2020-08-19 "Port the `df_prop` function" https://github.com/justuno-com/core/issues/204
 * @used-by \Justuno\Core\Zf\Validate::v()
 * @param object|null|ArrayAccess $o
 * @param mixed|string $v
 * @param string|mixed|null $d [optional]
 * @return mixed|object|ArrayAccess|null
 */
function ju_prop($o, $v = JU_N, $d = null, string $type = '') {/** @var object|mixed|null $r */
	/**
	 * 2019-09-08
	 * 1) My 1st solution was comparing $v with `null`,
	 * but it is wrong because it fails for a code like `$object->property(null)`.
	 * 2) My 2nd solution was using @see func_num_args():
	 * «How to tell if optional parameter in PHP method/function was set or not?»
	 * https://stackoverflow.com/a/3471863
	 * It is wrong because the $v argument is alwaus passed to df_prop()
	 */
	$isGet = JU_N === $v; /** @vae bool $isGet */
	if ('int' === $d) {
		$type = $d; $d = null;
	}
	/** @var string $k */
	if (!is_null($o)) {
		$r = ju_prop_k($o, ju_caller_f(), $v, $d);
	}
	else {# 2019-09-08 A static call.
		$k = ju_caller_m();
		# 2023-08-04
		# «dfa(): Argument #1 ($a) must be of type array, null given,
		# called in vendor/mage2pro/core/Core/lib/lang/prop.php on line 109»:
		# https://github.com/mage2pro/core/issues/314
		static $s = []; /** @var array(string => mixed) $s */
		if ($isGet) {
			$r = jua($s, $k, $d);
		}
		else {
			$s[$k] = $v;
			$r = null;
		}
	}
	return $isGet && 'int' === $type ? intval($r) : $r;
}

/**
 * 2022-10-28
 * 2023-07-29
 * 1) @noinspection PhpVariableVariableInspection
 * 2) "Suppress the «Variable variable used» inspection for the code intended for PHP < 8.2":
 * https://github.com/justuno-com/core/issues/395
 * @used-by ju_prop()
 * @param object|ArrayAccess $o
 * @param mixed|string $v [optional]
 * @param string|mixed|null $d [optional]
 * @return mixed|object|ArrayAccess|null
 */
function ju_prop_k($o, string $k, $v = JU_N, $d = null) {/** @var object|mixed|null $r */
	/**
	 * 2019-09-08
	 * 1) My 1st solution was comparing $v with `null`,
	 * but it is wrong because it fails for a code like `$object->property(null)`.
	 * 2) My 2nd solution was using @see func_num_args():
	 * «How to tell if optional parameter in PHP method/function was set or not?»
	 * https://stackoverflow.com/a/3471863
	 * It is wrong because the $v argument is alwaus passed to df_prop()
	 */
	$isGet = JU_N === $v; /** @vae bool $isGet */
	if ($o instanceof ArrayAccess) {
		if ($isGet) {
			$r = !$o->offsetExists($k) ? $d : $o->offsetGet($k);
		}
		else {
			$o->offsetSet($k, $v);
			$r = $o;
		}
	}
	else {
		$a = '_' . __FUNCTION__; /** @var string $a */
		/**
		 * 2022-10-18
		 * 1) Dynamic properties are deprecated since PHP 8.2:
		 * https://php.net/manual/migration82.deprecated.php#migration82.deprecated.core.dynamic-properties
		 * https://wiki.php.net/rfc/deprecate_dynamic_properties
		 * 2) @see dfc()
		 */
		static $hasWeakMap; /** @var bool $hasWeakMap */
		if (!($hasWeakMap = !is_null($hasWeakMap) ? $hasWeakMap : @class_exists('WeakMap'))) {
			if (!isset($o->$a)) {
				$o->$a = [];
			}
			if ($isGet) {
				$r = jua($o->$a, $k, $d);
			}
			else {
				# 2022-10-18
				# The previous code was:
				# 		$prop =& $o->$a;
				#		$prop[$k] = $v;
				# The new code works correctly in PHP ≤ 8.2: https://3v4l.org/8agSI1
				$o->{$a}[$k] = $v;
				$r = $o;
			}
		}
		else {
			static $map; /** @var WeakMap $map */
			$map = $map ?: new WeakMap;
			if (!$map->offsetExists($o)) {
				$map[$o] = [];
			}
			# 2022-10-17 https://3v4l.org/6cVAu
			$map2 =& $map[$o]; /** @var array(string => mixed) $map2 */
			if (!isset($map2[$a])) {
				$map2[$a] = [];
			}
			# 2022-10-18 https://3v4l.org/1tS4v
			$prop =& $map2[$a]; /** array(string => mixed) $prop */
			if ($isGet) {
				$r = jua($prop, $k, $d);
			}
			else {
				$prop[$k] = $v;
				$r = $o;
			}
		}
	}
	return $r;
}