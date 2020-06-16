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
	$args = df_args($args);
	$r = null;
	switch (count($args)) {
		case 0:
			$r = '';
			break;
		case 1:
			$r = $args[0];
			break;
		case 2:
			/** @var mixed $params */
			$params = $args[1];
			if (is_array($params)) {
				$r = strtr($args[0], $params);
			}
			break;
	}
	return !is_null($r) ? $r : df_sprintf($args);
}