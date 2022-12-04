<?php
/**
 * 2022-11-24
 * The @see DS constant exists in Magento 1: https://github.com/OpenMage/magento-mirror/blob/1.9.4.5/app/Mage.php#L27
 * It is absent in Magento 2.
 * It is also absent in PHP: https://3v4l.org/FTR0R
 */
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

/**
 * 2015-11-30
 * 2020-08-13 "Port the `df_trim_ds_left` function" https://github.com/justuno-com/core/issues/175
 * @used-by ju_path_relative()
 */
function ju_trim_ds_left(string $p):string {return ju_trim_left($p, '/\\');}