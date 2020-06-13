<?php
/**
 * 2016-02-09 "Port the `df_if1` function": https://github.com/justuno-com/core/issues/10
 * @used-by ju_request()
 * @param bool $cond
 * @param mixed|callable $onTrue
 * @param mixed|null $onFalse [optional]
 * @return mixed
 */
function ju_if1($cond, $onTrue, $onFalse = null) {return $cond ? df_call_if($onTrue) : $onFalse;}