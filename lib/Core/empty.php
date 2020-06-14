<?php
/**
 * 2020-06-14 "Port the `df_nes` function": https://github.com/justuno-com/core/issues/19
 * @used-by jua_deep()
 * @param mixed $v
 * @return bool
 */
function ju_nes($v) {return is_null($v) || '' === $v;}