<?php
use Exception as E;
/**
 * 2017-01-11
 * 2020-06-17 "Port the `df_log_e` function": https://github.com/justuno-com/core/issues/50
 * @used-by ju_error()
 * @param E $e
 * @param string|object|null $m [optional]
 * @param string|mixed[] $d [optional]
 * @param string|bool|null $suf [optional]
 */
function ju_log_e($e, $m = null, $d = [], $suf = null) {df_log_l($m, $e, $d, !is_null($suf) ? $suf : df_caller_f());}