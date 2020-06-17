<?php
/**
 * 2020-06-17 "Port the `df_first` function": https://github.com/justuno-com/core/issues/43
 * @used-by ju_sprintf()
 * @used-by ju_sprintf_strict()
 * @param array $a
 * @return mixed|null
 */
function ju_first(array $a) {return !$a ? null : reset($a);}

/**
 * 2020-06-17 "Port the `df_tail` function": https://github.com/justuno-com/core/issues/39
 * @used-by ju_error_create()
 * @used-by ju_sprintf_strict()
 * @param mixed[] $a
 * @return mixed[]|string[]
 */
function ju_tail(array $a) {return array_slice($a, 1);}