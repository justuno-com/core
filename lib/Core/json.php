<?php
/**
 * 2015-12-06
 * 2020-06-18 "Port the `df_json_encode` function": https://github.com/justuno-com/core/issues/65
 * @used-by ju_kv()
 * @used-by ju_log_l()
 * @param mixed $v
 * @param int $flags [optional]
 * @return string
 */
function ju_json_encode($v, $flags = 0) {return json_encode(df_json_sort($v),
	JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE | $flags
);}