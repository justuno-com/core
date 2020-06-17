<?php
/**
 * 2020-06-18 "Port the `df_cc_n` function": https://github.com/justuno-com/core/issues/56
 * @param string|string[] ...$args
 * @return string
 */
function ju_cc_n(...$args) {return df_ccc("\n", dfa_flatten($args));}