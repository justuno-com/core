<?php
/**
 * 2020-06-16 "Port the `df_starts_with` function": https://github.com/justuno-com/core/issues/30
 * @used-by \Justuno\Core\Qa\Trace::__construct()
 * @param string $haystack
 * @param string|string[] $needle
 * @return bool
 */
function ju_starts_with($haystack, $needle) {return is_array($needle)
	? null !== df_find($needle, __FUNCTION__, [], [$haystack])
	: $needle === mb_substr($haystack, 0, mb_strlen($needle))
;}

