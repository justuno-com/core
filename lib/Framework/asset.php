<?php
use Magento\Framework\View\Asset\File;
/**
 * 2015-12-29
 * By analogy with @see \Magento\Framework\View\Asset\File::getSourceFile():
 * https://github.com/magento/magento2/blob/2.0.0/lib/internal/Magento/Framework/View/Asset/File.php#L147-L156
 * @param string $name
 * $name could be:
 * 1) a short name;
 * 2) a full name composed with @see df_asset_name()
 * 2020-08-22 "Port the `df_asset_exists` function" https://github.com/justuno-com/core/issues/244
 * @used-by ju_fe_init()
 * @param string|null $m [optional]
 * @param string|null $ext [optional]
 * @return bool
 */
function ju_asset_exists($name, $m = null, $ext = null) {return jucf(
	function($name, $m = null, $ext = null) {return
		!!df_asset_source()->findSource(df_asset_create(df_asset_name($name, $m, $ext)))
	;}
, func_get_args());}