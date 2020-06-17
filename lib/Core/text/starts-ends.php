<?php
/**
 * 2020-06-17 "Port the `df_ends_with` function": https://github.com/justuno-com/core/issues/47
 * @used-by ju_is_bin_magento()
 * @param string $haystack
 * @param string|string[] $needle
 * @return bool
 */
function ju_ends_with($haystack, $needle) {return is_array($needle)
	? null !== ju_find($needle, __FUNCTION__, [], [$haystack])
	: 0 === ($l = mb_strlen($needle)) || $needle === mb_substr($haystack, -$l)
;}

/**
 * 2020-06-16 "Port the `df_starts_with` function": https://github.com/justuno-com/core/issues/30
 * @used-by \Justuno\Core\Qa\Trace::__construct()
 * @param string $haystack
 * @param string|string[] $needle
 * @return bool
 */
function ju_starts_with($haystack, $needle) {return is_array($needle)
	? null !== ju_find($needle, __FUNCTION__, [], [$haystack])
	: $needle === mb_substr($haystack, 0, mb_strlen($needle))
;}

