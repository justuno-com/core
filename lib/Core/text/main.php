<?php
use Justuno\Core\Helper\Text as T;

/**
 * 2020-06-18 "Port the `df_bts` function": https://github.com/justuno-com/core/issues/83
 * @used-by \Justuno\Core\Qa\Dumper::dump()
 * @used-by \Justuno\M2\Catalog\Variants::variant()
 */
function ju_bts(bool $v):string {return $v ? 'true' : 'false';}

/**
 * 2020-06-13 "Port the `df_contains` function": https://github.com/justuno-com/core/issues/16
 * 2022-10-14 @see str_contains() has been added to PHP 8: https://php.net/manual/function.str-contains.php
 * @used-by ju_caller_entry()
 * @used-by ju_error_create()
 * @used-by ju_file_name()
 * @used-by ju_request_ua()
 * @used-by ju_rp_has()
 * @used-by ju_trim()
 * @used-by jua()
 * @used-by \Justuno\Core\Cron\Model\LoggerHandler::p()
 * @used-by \Justuno\Core\Html\Tag::content()
 * @used-by \Justuno\Core\Sentry\Trace::get_frame_context()
 * @used-by \Justuno\M2\Catalog\Images::p()
 * @param string|string[] ...$n
 */
function ju_contains(string $haystack, ...$n):bool {/** @var bool $r */
	# 2017-07-10 This branch is exclusively for optimization.
	if (1 === count($n) && !is_array($n0 = $n[0])) {
		$r = false !== strpos($haystack, $n0);
	}
	else {
		$r = false;
		$n = jua_flatten($n);
		foreach ($n as $nItem) {/** @var string $nItem */
			if (false !== strpos($haystack, $nItem)) {
				$r = true;
				break;
			}
		}
	}
	return $r;
}

/**
 * 2020-06-20 "Port the `df_string` function": https://github.com/justuno-com/core/issues/92
 * @used-by ju_type()
 * @param mixed $v
 */
function ju_string($v):string {
	if (is_object($v)) {
		if (!method_exists($v, '__toString')) {
			ju_error('The developer wrongly treats an object of the class %s as a string.', get_class($v));
		}
	}
	elseif (is_array($v)) {
		ju_error('The developer wrongly treats an array as a string.');
	}
	return strval($v);
}

/**
 * 2020-06-20 "Port the `df_string_debug` function": https://github.com/justuno-com/core/issues/113
 * @used-by \Justuno\Core\Zf\Validate\Type::getDiagnosticMessageForNotNull()
 * @param mixed $v
 */
function ju_string_debug($v):string {
	$r = ''; /** @var string $r */
	if (is_object($v)) {
		if (!method_exists($v, '__toString')) {
			$r = get_class($v);
		}
	}
	elseif (is_array($v)) {
		$r = sprintf('<an array of %d elements>', count($v));
	}
	elseif (is_bool($v)) {
		$r = $v ? 'logical <yes>' : 'logical <no>';
	}
	else {
		$r = strval($v);
	}
	return $r;
}

/**
 * 2020-06-26 "Port the `df_t` function": https://github.com/justuno-com/core/issues/159
 * @used-by ju_quote_russian()
 */
function ju_t():T {return T::s();}