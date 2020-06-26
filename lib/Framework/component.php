<?php
use Magento\Framework\Component\ComponentRegistrar as R;

/**
 * 2019-12-31
 * It returns the fill filesystem path of the Magento Framework, e.g.:
 * «C:/work/clients/royalwholesalecandy.com-2019-12-08/code/vendor/magento/framework»
 * or «C:/work/clients/royalwholesalecandy.com-2019-12-08/code/lib/internal/magento/framework»
 * 2020-06-26 "Port the `df_framework_path` function": https://github.com/justuno-com/core/issues/149
 * @used-by ju_module_dir()
 * @return string
 */
function ju_framework_path() {return df_lib_path('magento/framework');}