<?php
/**
 * 2020-06-17 "Port the `df_args` function": https://github.com/justuno-com/core/issues/41
 * @used-by ju_clean()
 * @used-by ju_format()
 * @param mixed[] $a
 * @return mixed[]
 */
function ju_args(array $a) {return !$a || !is_array($a[0]) ? $a : $a[0];}

/**
 * 2020-06-13 "Port the `df_if1` function": https://github.com/justuno-com/core/issues/10
 * @used-by ju_request()
 * @param bool $cond
 * @param mixed|callable $onTrue
 * @param mixed|null $onFalse [optional]
 * @return mixed
 */
function ju_if1($cond, $onTrue, $onFalse = null) {return $cond ? ju_call_if($onTrue) : $onFalse;}