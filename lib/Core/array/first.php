<?php
/**
 * 2020-06-17 "Port the `df_first` function": https://github.com/justuno-com/core/issues/43
 * @used-by ju_caller_c()
 * @used-by ju_class_f()
 * @used-by ju_file_name()
 * @used-by ju_sprintf()
 * @used-by ju_sprintf_strict()
 * @used-by \Justuno\M2\Store::v()
 * @param array $a
 * @return mixed|null
 */
function ju_first(array $a) {return !$a ? null : reset($a);}

/**
 * 2020-08-19 "Port the `df_last` function" https://github.com/justuno-com/core/issues/200
 * @see ju_first()
 * @see ju_tail()
 * @used-by ju_class_l()
 * @param mixed[] $array
 * @return mixed|null
 */
function ju_last(array $array) {return !$array ? null : end($array);}