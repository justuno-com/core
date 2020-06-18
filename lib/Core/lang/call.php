<?php
use Closure as F;

/**
 * 2015-12-30
 * 2017-07-09 Now the function can accept an array as $object.
 * 2020-06-18 "Port the `df_call` function": https://github.com/justuno-com/core/issues/72
 * @used-by ju_each()
 * @param object|mixed|array $o
 * @param string|callable|F $m
 * @param mixed[] $p [optional]
 * @return mixed
 */
function ju_call($o, $m, $p = []) {/** @var mixed $r */
	if (is_array($o) && ju_is_assoc($o)) {
		$r = jua($o, $m);
	}
	elseif (!is_string($m)) {
		$r = call_user_func_array($m, array_merge([$o], $p));
	}
	else {
		$functionExists = function_exists($m); /** @var bool $functionExists */
		/**
		 * 2020-02-05
		 * 1) @uses is_callable() always returns `true` for an object which the magic `__call` method
		 * (e.g., for all @see \Magento\Framework\DataObject ancestors),
		 * but it returns `false` for private and protected (so non-callable) methods.
		 * 2) @uses method_exists() returns `true` even for private and protected (so non-callable) method,
		 * but it returns `false` for absent methods handled by `__call`.
		 * 3) The conjunction of these 2 checks returns `true` only for publicly accessible and really exists
		 * (not handled by `__call`) methods.
		 */
		$methodExists = is_callable([$o, $m]) && method_exists($o, $m); /** @var bool $methodExists */
		$callable = null; /** @var mixed $callable */
		if ($functionExists && !$methodExists) {
			$callable = $m;
			$p = array_merge([$o], $p);
		}
		elseif ($methodExists && !$functionExists) {
			$callable = [$o, $m];
		}
		if ($callable) {
			$r = call_user_func_array($callable, $p);
		}
		else if (df_has_gd($o)) {
			$r = juad($o, $m);
		}
		elseif (!$functionExists) {
			ju_error("Unable to call «{$m}».");
		}
		else {
			ju_error("An ambiguous name: «{$m}».");
		}
	}
	return $r;
}

/**
 * 2020-06-13 "Port the `df_call_if` function": https://github.com/justuno-com/core/issues/11
 * https://3v4l.org/iUQGl
 *	 function a($b) {return is_callable($b);}
 *	 a(function() {return 0;}); возвращает true
 * https://3v4l.org/MfmCj
 *	is_callable('intval') возвращает true
 * @used-by ju_if1()
 * @used-by jua()
 * @param mixed|callable $v
 * @param mixed ...$a [optional]
 * @return mixed
 */
function ju_call_if($v, ...$a) {return
	is_callable($v) && !is_string($v) && !is_array($v) ? call_user_func_array($v, $a) : $v
;}