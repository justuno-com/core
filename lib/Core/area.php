<?php
use Magento\Framework\App\Area as A;

/**
 * 2015-08-14
 * 2020-06-24 "Port the `df_is_backend` function": https://github.com/justuno-com/core/issues/125
 * @used-by ju_store()
 * @return bool
 */
function ju_is_backend() {return df_area_code_is(A::AREA_ADMINHTML) || df_is_ajax() && df_backend_user();}