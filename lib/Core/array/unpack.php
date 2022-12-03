<?php
/**
 * 2020-06-17 "Port the `df_args` function": https://github.com/justuno-com/core/issues/41
 * @used-by ju_clean()
 * @used-by ju_format()
 */
function ju_args(array $a):array {return !$a || !is_array($a[0]) ? $a : $a[0];}