<?php

/**
 * 2016-10-25 http://stackoverflow.com/a/1042533
 * 2020-06-17 "Port the `df_is_cli` function": https://github.com/justuno-com/core/issues/36
 * @used-by ju_header_utf()
 * @return bool
 */
function ju_is_cli() {return 'cli' === php_sapi_name();}