<?php
/**
 * 2016-01-14
 * 2020-08-21 "Port the `df_lcfirst` function" https://github.com/justuno-com/core/issues/219
 * @used-by ju_explode_class_lc()
 * @used-by ju_explode_class_lc_camel()
 * @param string|string[] $a
 * @return string|string[]
 */
function ju_lcfirst(...$a) {return ju_call_a(function(string $s):string {return
	mb_strtolower(mb_substr($s, 0, 1)) . mb_substr($s, 1)
;}, $a);}