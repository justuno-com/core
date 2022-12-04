<?php
/**
 * 2020-06-17 "Port the `df_format` function": https://github.com/justuno-com/core/issues/40
 * @used-by ju_error_create()
 * @used-by \Justuno\Core\Exception::comment()
 * @param mixed ...$a
 */
function ju_format(...$a):string { /** @var string $r */
	$a = ju_args($a);
	$r = null;
	switch (count($a)) {
		case 0:
			$r = '';
			break;
		case 1:
			$r = $a[0];
			break;
		case 2:
			if (is_array($a[1])) {
				$r = strtr($a[0], $a[1]);
			}
			break;
	}
	return !is_null($r) ? $r : ju_sprintf($a);
}

/**
 * 2017-07-09
 * 2020-06-18 "Port the `df_kv` function": https://github.com/justuno-com/core/issues/56
 * @used-by \Justuno\Core\Sentry\Client::send_http()
 * @param array(string => string) $a
 */
function ju_kv(array $a, int $pad = 0):string {return ju_cc_n(ju_map_k(ju_clean($a), function($k, $v) use($pad) {return
	(!$pad ? "$k: " : ju_pad("$k:", $pad))
	.(is_array($v) || (is_object($v) && !method_exists($v, '__toString')) ? "\n" . ju_json_encode($v) : $v)
;}));}

/**
 * 2020-06-17 "Port the `df_sprintf` function": https://github.com/justuno-com/core/issues/42
 * @used-by ju_format()
 * @param string|mixed[] $s
 * @throws Exception
 */
function ju_sprintf($s):string {/** @var string $r */ /** @var mixed[] $args */
	# 2020-03-02
	# The square bracket syntax for array destructuring assignment (`[…] = […]`) requires PHP ≥ 7.1:
	# https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	# We should support PHP 7.0.
	list($s, $args) = is_array($s) ? [ju_first($s), $s] : [$s, func_get_args()];
	try {$r = ju_sprintf_strict($args);}
	catch (Exception $e) {$r = $s;}
	return $r;
}

/**
 * 2020-06-17 "Port the `df_sprintf_strict` function": https://github.com/justuno-com/core/issues/44
 * @used-by ju_sprintf()
 * @param string|mixed[] $s
 * @throws Exception
 */
function ju_sprintf_strict($s):string {/** @var string $r */ /** @var mixed[] $args */
	# 2020-03-02
	# The square bracket syntax for array destructuring assignment (`[…] = […]`) requires PHP ≥ 7.1:
	# https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	# We should support PHP 7.0.
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
				ju_error(
					'ju_sprintf_strict failed: «{message}».'
					. "\nPattern: {$s}."
					. "\nParameters:\n{params}."
					,['{message}' => ju_ets($e), '{params}' => print_r(ju_tail($args), true)]
				);
			}
		}
	}
	return $r;
}

/**
 * 2020-06-22 "Port the `df_var` function": https://github.com/justuno-com/core/issues/104
 * @used-by ju_file_name()
 * @param array(string => string) $variables
 * @param string|callable|null $onUnknown
 */
function ju_var(string $s, array $variables, $onUnknown = null):string {return preg_replace_callback(
	'#\{([^\}]*)\}#ui', function($m) use($variables, $onUnknown) {return
		jua($variables, jua($m, 1, ''), $onUnknown)
	;}, $s
);}