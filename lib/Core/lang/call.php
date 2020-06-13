<?php
/**
 * 2020-06-13 "Port the `df_call_if` function": https://github.com/justuno-com/core/issues/11
 * https://3v4l.org/iUQGl
 *	 function a($b) {return is_callable($b);}
 *	 a(function() {return 0;}); возвращает true
 * https://3v4l.org/MfmCj
 *	is_callable('intval') возвращает true
 * @used-by ju_if1()
 * @used-by jua()
 * @param mixed|callable $v
 * @param mixed ...$a [optional]
 * @return mixed
 */
function ju_call_if($v, ...$a) {return
	is_callable($v) && !is_string($v) && !is_array($v) ? call_user_func_array($v, $a) : $v
;}