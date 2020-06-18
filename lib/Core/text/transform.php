<?php
/**
 * 2020-06-18 "Port the `df_ucfirst` function": https://github.com/justuno-com/core/issues/78
 * @used-by ju_assert_gd()
 * @param string ...$args
 * @return string|string[]
 */
function ju_ucfirst(...$args) {return ju_call_a(function($s) {return
	mb_strtoupper(mb_substr($s, 0, 1)) . mb_substr($s, 1)
;}, $args);}