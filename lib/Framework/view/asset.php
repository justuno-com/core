<?php
use Magento\Framework\View\Asset\File;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\View\Asset\Source;

/**
 * 2015-10-27
 * 2020-08-22 "Port the `df_asset` function" https://github.com/justuno-com/core/issues/250
 * @used-by ju_asset_create()
 */
function ju_asset():Repository {return ju_o(Repository::class);}

/**
 * 2015-10-27 http://stackoverflow.com/questions/4659345
 * 2020-08-22 "Port the `df_asset_create` function" https://github.com/justuno-com/core/issues/249
 * @used-by ju_asset_exists()
 * @used-by ju_resource_inline()

 */
function ju_asset_create(string $u):File {$a = ju_asset(); return !ju_check_url_absolute($u)
	? $a->createAsset($u)
	: $a->createRemoteAsset($u, jua(['css' => 'text/css', 'js' => 'application/javascript'], ju_file_ext($u)))
;}

/**
 * 2015-12-29
 * 1) By analogy with @see \Magento\Framework\View\Asset\File::getSourceFile():
 * https://github.com/magento/magento2/blob/2.0.0/lib/internal/Magento/Framework/View/Asset/File.php#L147-L156
 * 2) $name could be:
 * 1) a short name;
 * 2) a full name composed with @see ju_asset_name()
 * 2020-08-22 "Port the `df_asset_exists` function" https://github.com/justuno-com/core/issues/244
 * @used-by ju_fe_init()
 */
function ju_asset_exists(string $name, string $m = '', string $ext = ''):bool {return jucf(
	function($name, $m = null, $ext = null) {return
		!!ju_asset_source()->findSource(ju_asset_create(ju_asset_name($name, $m, $ext)))
	;}
, func_get_args());}

/**
 * 2015-12-29
 * $name could be:
 * 		1) a short name;
 * 		2) a full name composed with @see ju_asset_name(). In this case, the function returns $name without changes.
 * 2020-08-22 "Port the `df_asset_name` function" https://github.com/justuno-com/core/issues/245
 * @used-by ju_asset_exists()
 * @used-by ju_fe_init()
 * @param string|object|null $m [optional]
 */
function ju_asset_name(string $name = '', $m = null, string $ext = ''):string {return ju_ccc(
	'.', ju_ccc('::', $m ? ju_module_name($m) : null, $name ?: 'main'), $ext
);}

/**
 * 2015-12-29
 * 2020-08-22 "Port the `df_asset_source` function" https://github.com/justuno-com/core/issues/248
 * @used-by ju_asset_exists()
 */
function ju_asset_source():Source {return ju_o(Source::class);}