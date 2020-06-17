<?php
/**
 * 2020-06-17 "Port the `df_format` function": https://github.com/justuno-com/core/issues/40
 * @used-by ju_error_create()
 * @used-by \Justuno\Core\Exception::comment()
 * @used-by \Justuno\Core\Exception::commentPrepend()
 * @param mixed ...$args
 * @return string
 */
function ju_format(...$args) { /** @var string $r */
	$args = ju_args($args);
	$r = null;
	switch (count($args)) {
		case 0:
			$r = '';
			break;
		case 1:
			$r = $args[0];
			break;
		case 2:
			if (is_array($args[1])) {
				$r = strtr($args[0], $args[1]);
			}
			break;
	}
	return !is_null($r) ? $r : ju_sprintf($args);
}

/**
 * 2020-06-17 "Port the `df_sprintf` function": https://github.com/justuno-com/core/issues/42
 * @used-by ju_format()
 * @param string|mixed[] $s
 * @return string
 * @throws Exception
 */
function ju_sprintf($s) {/** @var string $r */ /** @var mixed[] $args */
	// 2020-03-02
	// The square bracket syntax for array destructuring assignment (`[…] = […]`) requires PHP ≥ 7.1:
	// https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	// We should support PHP 7.0.
	list($s, $args) = is_array($s) ? [ju_first($s), $s] : [$s, func_get_args()];
	try {$r = ju_sprintf_strict($args);}
	catch (Exception $e) {$r = $s;}
	return $r;
}

/**
 * 2020-06-17 "Port the `df_sprintf_strict` function": https://github.com/justuno-com/core/issues/44
 * @used-by ju_sprintf()
 * @param string|mixed[] $s
 * @return string
 * @throws \Exception
 */
function ju_sprintf_strict($s) {/** @var string $r */ /** @var mixed[] $args */
	// 2020-03-02
	// The square bracket syntax for array destructuring assignment (`[…] = […]`) requires PHP ≥ 7.1:
	// https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	// We should support PHP 7.0.
	list($s, $args) = is_array($s) ? [ju_first($s), $s] : [$s, func_get_args()];
	if (1 === count($args)) {
		$r = $s;
	}
	else {
		try {$r = vsprintf($s, ju_tail($args));}
		catch (Exception $e) {/** @var bool $inProcess */
			static $inProcess = false;
			if (!$inProcess) {
				$inProcess = true;
				df_error(
					'df_sprintf_strict failed: «{message}».'
					. "\nPattern: {$s}."
					. "\nParameters:\n{params}."
					,['{message}' => ju_ets($e), '{params}' => print_r(ju_tail($args), true)]
				);
				$inProcess = false;
			}
		}
	}
	return $r;
}