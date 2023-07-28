<?php
/**
 * http://stackoverflow.com/a/15011528
 * http://www.php.net/manual/en/function.filter-var.php
 * filter_var('/C/A/CA559AWLE574_1.jpg', FILTER_VALIDATE_URL) returns `false`.
 * 2023-07-26
 * 1) "`df_check_url` → `df_is_url`": https://github.com/mage2pro/core/issues/276
 * 2) df_is_url('php://input') returns `true`:
 * https://github.com/mage2pro/core/issues/277
 * https://3v4l.org/mTt87
 * @used-by ju_contents()
 */
function ju_is_url(string $s):bool {return false !== filter_var($s, FILTER_VALIDATE_URL);}

/**
 * 2017-10-16
 * 2020-08-22 "Port the `df_check_url_absolute` function" https://github.com/justuno-com/core/issues/251
 * @used-by ju_asset_create()
 * @used-by ju_js()
 */
function ju_is_url_absolute(string $u):bool {return ju_starts_with($u, ['http', '//']);}