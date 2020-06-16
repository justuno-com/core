<?php
/**
 * 2020-06-17 "Port the `df_tail` function": https://github.com/justuno-com/core/issues/39
 * @used-by ju_error_create()
 * @param mixed[] $a
 * @return mixed[]|string[]
 */
function ju_tail(array $a) {return array_slice($a, 1);}