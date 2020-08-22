<?php
/**
 * 2017-10-16
 * 2020-08-22 "Port the `df_check_url_absolute` function" https://github.com/justuno-com/core/issues/251
 * @used-by ju_asset_create()
 * @used-by ju_js()
 * @param string $u
 * @return bool
 */
function ju_check_url_absolute($u) {return ju_starts_with($u, ['http', '//']);}