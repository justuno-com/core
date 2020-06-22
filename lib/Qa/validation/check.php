<?php
/**
 * 2020-06-22 "Port the `df_check_s` function": https://github.com/justuno-com/core/issues/109
 * @used-by ju_result_s()
 * @param string $v
 * @return bool
 */
function ju_check_s($v) {return \Justuno\Core\Zf\Validate\StringT::s()->isValid($v);}