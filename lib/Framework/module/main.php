<?php
use Magento\Framework\Module\Manager as MM;
/**
 * 2019-11-21
 * 2020-08-23 "Port the `df_module_enabled` function" https://github.com/justuno-com/core/issues/282
 * @used-by ju_caller_module()
 * @used-by ju_log_l()
 * @used-by ju_msi()
 * @used-by ju_x_entry()
 */
function ju_module_enabled(string $m):bool {return ju_module_m()->isEnabled($m);}

/**
 * 2019-11-21
 * 2020-08-23 "Port the `ju_module_m` function" https://github.com/justuno-com/core/issues/283
 * @used-by ju_module_enabled()
 */
function ju_module_m():MM {return ju_o(MM::class);}