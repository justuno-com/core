<?php
use Composer\Autoload\ClassLoader as CL;
use Composer\InstalledVersions as IV;
use Composer\Package\RootPackage as Root;
use Magento\Framework\App\ProductMetadata as Metadata;
use Magento\Framework\App\ProductMetadataInterface as IMetadata;

/**
 * 2016-06-25 https://mage2.pro/t/543
 * 2018-04-17
 * 1) «Magento 2.3 has removed its version information from the `composer.json` files since 2018-04-05»:
 * https://mage2.pro/t/5480
 * 2) Now Magento 2.3 (installed with Git) returns the «dev-2.3-develop» string from the
 * @see \Magento\Framework\App\ProductMetadata::getVersion() method.
 * 2020-06-26 "Port the `df_magento_version` function": https://github.com/justuno-com/core/issues/153
 * 2023-07-16
 * 1) @see \Magento\Framework\App\ProductMetadata::getVersion() has stopped working correctly for Magento installed via Git:
 * https://github.com/mage2pro/core/issues/229
 * 2) «Script error for "Magento_Ui/js/lib/ko/template/renderer"»: https://github.com/mage2pro/core/issues/228
 * @used-by ju_context()
 * @used-by ju_sentry()
 * @used-by ju_sentry_m()
 * @used-by \Justuno\Core\Qa\Trace\Frame::url()
 */
function ju_magento_version():string {return jucf(function() {
	/** @var string $r */
	if (
		/**
		 * 2023-07-21
		 * "\Magento\Framework\App\ProductMetadata::getVersion() returns «1.0.0+no-version-set»
		 * in Magento2.4.7-beta1 installed via Git": https://github.com/mage2pro/core/issues/229
		 */
		ROOT::DEFAULT_PRETTY_VERSION === ($r = ju_magento_version_m()->getVersion())
		/**
		 * 2023-07-23
		 * 1) @uses \Composer\InstalledVersions::getRootPackage():
		 * 		$installed = self::getInstalled();
		 * 		return $installed[0]['root'];
		 * 2) @see \Composer\InstalledVersions::getInstalled()
		 * returns `[null]` in tradefurniturecompany.co.uk (Windows, PHP 7.4).
		 * 3) It is because of the code:
		 * 		self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
		 * 4) The @see \Composer\Autoload\ClassLoader presents in Magento 2.3.7 in 2 different versions:
		 * 4.1) vendor/composer/composer/src/Composer/Autoload/ClassLoader.php
		 * 4.2) vendor/composer/ClassLoader.php
		 * 5) The `vendor/composer/ClassLoader.php` class is outdated
		 * and does not have the @see \Composer\Autoload\ClassLoader::getRegisteredLoaders() method.
		 * 6) That is why @see \Composer\InstalledVersions::getInstalled() returns `[null].
		 * 7) It leads to the failure:
		 * «Trying to access array offset on value of type null
		 * in vendor/composer/composer/src/Composer/InstalledVersions.php on line 198»:
		 * https://github.com/mage2pro/core/issues/243
		 */
		&& method_exists(CL::class, 'getRegisteredLoaders')
	) {
		/**
		 * 2023-07-16
		 * 1) https://getcomposer.org/doc/07-runtime.md#installed-versions
		 * 2) @uses \Composer\InstalledVersions::getRootPackage() returns:
		 *	{
		 *		"aliases": [],
		 *		"dev": true,
		 *		"install_path": "C:\\work\\clients\\m\\latest\\code\\vendor\\composer/../../",
		 *		"name": "magento/magento2ce",
		 *		"pretty_version": "dev-2.4-develop",
		 *		"reference": "1bdf9dfaf502ab38f5174f33b05c0690f67bf572",
		 *		"type": "project",
		 *		"version": "dev-2.4-develop"
		 *	}
		 */
		$r = jua(IV::getRootPackage(), 'pretty_version');
	}
	return ju_trim_text_left($r, 'dev-');
});}

/**
 * 2016-06-25
 * @used-by ju_magento_version()
 * @return IMetadata|Metadata
 */
function ju_magento_version_m() {return ju_o(IMetadata::class);}