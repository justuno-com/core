<?php
/**
 * 2020-06-14 "Port the `df_explode_xpath` function": https://github.com/justuno-com/core/issues/20
 * @used-by jua_deep()
 * @param string|string[] $p
 * @return string[]
 */
function ju_explode_xpath($p) {return jua_flatten(array_map(function($s) {return explode('/', $s);}, ju_array($p)));}