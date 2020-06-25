<?php
use Magento\Framework\Config\Composer\Package;

/**
 * 2017-01-25
 * 2020-06-26 "Port the `df_core_version` function": https://github.com/justuno-com/core/issues/143
 * @used-by ju_sentry()
 * @return string
 */
function ju_core_version() {return jucf(function() {return ju_package_version('Justuno_Core');});}

/**
 * 2016-06-26
 * The method can be used not only for custom packages, but for standard Magento packages too.
 * «How to programmatically get an extension's version from its composer.json file?» https://mage2.pro/t/1798
 * 2017-04-10
 * From now on, the function gets the package's name from the package's `composer.json` file only.
 * A package's name as $m is not allowed anymore.
 * 2020-06-26 "Port the `df_package_version` function": https://github.com/justuno-com/core/issues/144
 * @used-by ju_core_version()
 * @param string|object|null $m [optional]
 * @return string|null
 */
function ju_package_version($m = null) {return df_package($m, 'version');}