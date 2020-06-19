<?php
/**
 * 2018-04-24 I have added @uses trim() today.
 * 2020-06-20 "Port the `df_explode_n` function": https://github.com/justuno-com/core/issues/86
 * @used-by ju_tab_multiline()
 * @param string $s
 * @return string[]
 */
function ju_explode_n($s) {return explode("\n", df_normalize(df_trim($s)));}

/**
 * 2020-06-14 "Port the `df_explode_xpath` function": https://github.com/justuno-com/core/issues/20
 * @used-by jua_deep()
 * @param string|string[] $p
 * @return string[]
 */
function ju_explode_xpath($p) {return jua_flatten(array_map(function($s) {return explode('/', $s);}, ju_array($p)));}