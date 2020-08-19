<?php
/**
 * 2016-08-10
 * The original (not used now) implementation: https://github.com/mage2pro/core/blob/6.7.3/Core/lib/caller.php#L125-L136
 * 2017-03-28
 * The df_caller_mm() implementation: https://github.com/mage2pro/core/blob/6.7.3/Core/lib/caller.php#L155-L169
 * 2020-07-08 The function's new implementation is from the previous df_caller_mm() function.
 * 2020-08-19 "Port the `df_caller_m` function" https://github.com/justuno-com/core/issues/205
 * @used-by ju_prop()
 * @param int $o [optional]
 * @return string
 */
function ju_caller_m($o = 0) {
	$bt = df_caller_entry(++$o); /** @var array(string => int) $bt */
	$class = jua($bt, 'class'); /** @var string $class */
	if (!$class) {
		ju_log_l(null, $m = "df_caller_m(): no class.\nbt is:\n$bt", __FUNCTION__); /** @var string $m */
		ju_error($m);
	}
	return "$class::{$bt['function']}";
}