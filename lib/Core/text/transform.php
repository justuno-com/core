<?php
/**
 * 2016-01-14
 * 2020-08-21 "Port the `df_lcfirst` function" https://github.com/justuno-com/core/issues/219
 * @see ju_ucfirst()
 * @used-by ju_explode_class_lc()
 * @used-by ju_explode_class_lc_camel()
 * @param string|string[] $a
 * @return string|string[]
 */
function ju_lcfirst(...$a) {return ju_call_a(function(string $s):string {return
	mb_strtolower(mb_substr($s, 0, 1)) . mb_substr($s, 1)
;}, $a);}

/**
 * Эта функция умеет работать с UTF-8, в отличие от стандартной функции @see ucfirst()
 * 2022-11-26 We can not declare the argument as `string ...$a` because such a syntax will reject arrays: https://3v4l.org/jFdPm
 * @see ju_lcfirst
 * @used-by ju_assert_gd()
 * @used-by \Justuno\Core\Qa\Trace\Frame::url()
 * @param string|string[] $a
 * @return string|string[]
 */
function ju_ucfirst(...$a) {return ju_call_a(function(string $s):string {return
	mb_strtoupper(mb_substr($s, 0, 1)) . mb_substr($s, 1)
;}, $a);}