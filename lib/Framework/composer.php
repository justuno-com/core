<?php
/**
 * 2017-01-25
 * 2020-06-26 "Port the `df_core_version` function": https://github.com/justuno-com/core/issues/143
 * @used-by ju_context()
 * @used-by ju_sentry()
 * @used-by ju_sentry_m()
 * @used-by \Justuno\Core\Qa\Trace\Frame::url()
 * @used-by \Justuno\Core\Sentry\Client::capture()
 * @used-by \Justuno\Core\Sentry\Client::getUserAgent()
 */
function ju_core_version():string {return jucf(function() {return ju_package_version('Justuno_Core');});}

/**
 * 2017-01-10
 * The function gets the package's information from the package's `composer.json` file.
 * $m could be:
 * 1) a module name: «A_B»
 * 2) a class name: «A\B\C».
 * 3) an object: it comes down to the case 2 via @see get_class()
 * 4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2020-06-26 "Port the `df_package` function": https://github.com/justuno-com/core/issues/145
 * @used-by ju_package()
 * @used-by ju_package_name_l()
 * @used-by ju_package_version()
 * @param string|object|null $m [optional]
 * @param string|string[]|null $k [optional]
 * @param mixed|null $d [optional]
 * @return string|array(string => mixed)|null
 */
function ju_package($m = null, $k = null, $d = null) {
	static $cache; /** @var array(string => array(string => mixed)) $cache */
	if (!isset($cache[$m = ju_module_name($m)])) {
		$packagePath = ju_module_path($m); /** @var string $packagePath */
		# 2017-01-10 All `Df_*` modules share the common `composer.json` located in the parent folder.
		if (ju_starts_with($m, 'Df_')) {
			$packagePath = dirname($packagePath);
		}
		$filePath = "$packagePath/composer.json"; /** @var string $filePath */
        # 2023-01-28
        # 1) The `composer.json` file can be absent for a module, e.g.:
        # https://github.com/elgentos/magento2-regenerate-catalog-urls/tree/0.2.14/Iazel/RegenProductUrl
        # 2) "«Unable to read the file vendor/elgentos/regenerate-catalog-urls/Iazel/RegenProductUrl/composer.json»
        # on `bin/magento setup:static-content:deploy`": https://github.com/tradefurniturecompany/site/issues/240
		$cache[$m] = ju_eta(ju_json_decode(ju_contents($filePath, '')));
	}
	return jua($cache[$m], $k, $d);
}

/**
 * 2017-04-16
 * @used-by ju_api_version()
 * @param string|object|null $m [optional]
 * @return string|null
 */
function ju_package_name_l($m = null) {return ju_last(explode('/', ju_package($m, 'name')));}

/**
 * 2016-06-26
 * The method can be used not only for custom packages, but for standard Magento packages too.
 * «How to programmatically get an extension's version from its composer.json file?» https://mage2.pro/t/1798
 * 2017-04-10
 * From now on, the function gets the package's name from the package's `composer.json` file only.
 * A package's name as $m is not allowed anymore.
 * 2020-06-26 "Port the `df_package_version` function": https://github.com/justuno-com/core/issues/144
 * @used-by ju_core_version()
 * @used-by ju_sentry()
 * @used-by ju_sentry_m()
 * @param string|object|null $m [optional]
 * @return string|null
 */
function ju_package_version($m = null) {return ju_package($m, 'version');}