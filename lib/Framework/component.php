<?php
use Magento\Framework\Component\ComponentRegistrar as R;

/**
 * 2019-12-31
 * 2020-06-26 "Port the `df_component_r` function": https://github.com/justuno-com/core/issues/151
 * @used-by ju_lib_path()
 */
function ju_component_r():R {return ju_o(R::class);}

/**
 * 2019-12-31
 * It returns the fill filesystem path of the Magento Framework, e.g.:
 * «C:/work/clients/royalwholesalecandy.com-2019-12-08/code/vendor/magento/framework»
 * or «C:/work/clients/royalwholesalecandy.com-2019-12-08/code/lib/internal/magento/framework»
 * 2020-06-26 "Port the `df_framework_path` function": https://github.com/justuno-com/core/issues/149
 * @used-by ju_module_dir()
 */
function ju_framework_path():string {return ju_lib_path('magento/framework');}

/**
 * 2019-12-31
 * It returns the fill filesystem path of a library, e.g.:
 * «C:/work/clients/royalwholesalecandy.com-2019-12-08/code/vendor/magento/framework»
 * or «C:/work/clients/royalwholesalecandy.com-2019-12-08/code/lib/internal/magento/framework»
 * 2020-06-26 "Port the `df_lib_path` function": https://github.com/justuno-com/core/issues/150
 * @used-by ju_framework_path()
 */
function ju_lib_path(string $l):string {return ju_component_r()->getPath(R::LIBRARY, $l);}