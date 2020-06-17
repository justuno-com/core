<?php
/**
 * 2020-06-18 "Port the `df_cc_n` function": https://github.com/justuno-com/core/issues/63
 * @used-by ju_kv()
 * @param string|string[] ...$args
 * @return string
 */
function ju_cc_n(...$args) {return ju_ccc("\n", jua_flatten($args));}

/**
 * 2020-06-18 "Port the `df_ccc` function": https://github.com/justuno-com/core/issues/57
 * @used-by ju_cc_n
 * @param string $glue
 * @param string|string[] ...$elements
 * @return string
 */
function ju_ccc($glue, ...$elements) {return implode($glue, ju_clean(jua_flatten($elements)));}