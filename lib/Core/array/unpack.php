<?php
/**
 * 2022-11-26
 * 1) https://3v4l.org/C09vn
 * 2) It is similar to @see dfa_unpack(), but df_arg() does not call dfa_flatten().
 * 3)
 * 		[$v] => $v
 * 		[[$v]] => [$v]
 * 		[[$v1, $v2]] => [$v1, $v2]
 * 		[$v1, $v2] => [$v1, $v2]
 * 		[$v1, $v2, [$v3]] => [$v1, $v2, [$v3]] - The difference from @see jua_unpack()
 * 		[] => []
 * @see ju_args()
 * @see jua_unpack()
 * @used-by ju_contains()
 * @return mixed|mixed[]
 */
function ju_arg(array $a) {return isset($a[0]) && !isset($a[1]) ? $a[0] : $a;}

/**
 * 2020-06-17 "Port the `df_args` function": https://github.com/justuno-com/core/issues/41
 * @used-by ju_clean()
 * @used-by ju_format()
 */
function ju_args(array $a):array {return !$a || !is_array($a[0]) ? $a : $a[0];}