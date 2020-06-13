<?php
/**
 * 2020-06-13 "Port the `df_o` function": https://github.com/justuno-com/core/issues/3
 * @used-by ju_request_o()
 * @param string $t
 * @return mixed
 */
function ju_o($t) {return dfcf(function($t) {return df_om()->get($t);}, [$t]);}