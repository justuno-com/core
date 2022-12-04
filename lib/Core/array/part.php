<?php
/**
 * 2021-10-05, 2021-11-30
 * @uses array_slice() returns an empty array if `$limit` is `0`, and returns all elements if `$limit` is `null`,
 * so I convert `0` and other empty values to `null`.
 * @used-by ju_bt()
 */
function ju_slice(array $a, int $offset, int $length = 0):array {return array_slice($a, $offset, ju_etn($length));}

/**
 * 2020-06-17 "Port the `df_tail` function": https://github.com/justuno-com/core/issues/39
 * @used-by ju_error_create()
 * @used-by ju_sprintf_strict()
 * @param mixed[] $a
 * @return mixed[]|string[]
 */
function ju_tail(array $a) {return array_slice($a, 1);}