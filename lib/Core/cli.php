<?php
/**
 * 2017-03-15
 * 2020-06-17 "Port the `df_cli_argv` function": https://github.com/justuno-com/core/issues/49
 * @used-by ju_cli_script()
 * @param int $i [optional]
 * @return string|string[]
 */
function ju_cli_argv($i = null) {return jua(jua($_SERVER, 'argv', []), $i);}

/**
 * 2020-02-15
 * 2020-06-17 "Port the `df_cli_script` function": https://github.com/justuno-com/core/issues/48
 * @used-by ju_is_bin_magento()
 * @return string
 */
function ju_cli_script() {return ju_cli_argv(0);}

/**
 * 2020-02-15
 * 1) `bin/magento` can be called with a path prefix, so I use @uses ju_ends_with()
 * 2) df_cli_script() returns «bin/magento» even in the `php bin/magento ...` case.
 * 2020-06-17 "Port the `df_is_bin_magento` function": https://github.com/justuno-com/core/issues/46
 * @used-by ju_is_cron()
 * @return bool
 */
function ju_is_bin_magento() {return ju_ends_with(ju_cli_script(), 'bin/magento');}

/**
 * 2016-10-25 http://stackoverflow.com/a/1042533
 * 2020-06-17 "Port the `df_is_cli` function": https://github.com/justuno-com/core/issues/36
 * @used-by ju_header_utf()
 * @return bool
 */
function ju_is_cli() {return 'cli' === php_sapi_name();}