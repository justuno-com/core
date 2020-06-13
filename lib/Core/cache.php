<?php
use Justuno\Core\RAM;
/**
 * 2020-06-13 "Port the `dfcf` function": https://github.com/justuno-com/core/issues/5
 * @used-by ju_o()
 * @param \Closure $f
 * @param mixed[] $a [optional]
 * @param string[] $tags [optional]
 * @param bool $unique [optional]
 * @param int $offset [optional]
 * @return mixed
 */
function jucf(\Closure $f, array $a = [], array $tags = [], $unique = true, $offset = 0) {
	$b = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2 + $offset)[1 + $offset]; /** @var array(string => string) $b */
	/** @var string $k */
	$k = (!isset($b['class']) ? null : $b['class'] . '::') . $b['function']
		. (!$a ? null : '--' . ju_hash_a($a))
		. ($unique ? null : '--' . spl_object_hash($f))
	;
	$r = ju_ram(); /** @var RAM $r */
	/**
	 * 2017-01-12
	 * The following code will return `3`:
	 * 		$a = function($a, $b) {return $a + $b;};
	 * 		$b = [1, 2];
	 * 		echo $a(...$b);
	 * https://3v4l.org/0shto
	 */
	return $r->exists($k) ? $r->get($k) : $r->set($k, $f(...$a), $tags);
}

/**
 * 2020-06-13 "Port the `df_ram` function": https://github.com/justuno-com/core/issues/8
 * @used-by jucf()
 * @return RAM
 */
function ju_ram() {return RAM::s();}