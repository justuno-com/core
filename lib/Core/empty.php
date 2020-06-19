<?php
/**
 * 2020-06-14 "Port the `df_nes` function": https://github.com/justuno-com/core/issues/19
 * @used-by jua_deep()
 * @param mixed $v
 * @return bool
 */
function ju_nes($v) {return is_null($v) || '' === $v;}

/**
 * 2020-06-20 "Port the `df_nts` function": https://github.com/justuno-com/core/issues/89
 * @used-by ju_trim()
 * @param mixed|null $v
 * @return mixed
 */
function ju_nts($v) {return !is_null($v) ? $v : '';}