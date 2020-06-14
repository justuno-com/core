<?php
/**
 * 2020-06-14 "Port the `df_explode_xpath` function": https://github.com/justuno-com/core/issues/20
 * @used-by jua_deep()
 * @used-by \Df\Config\Backend::value()
 * @param string|string[] $p
 * @return string[]
 */
function ju_explode_xpath($p) {return jua_flatten(array_map(function($s) {return explode('/', $s);}, df_array($p)));}