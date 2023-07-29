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
function ju_magento_version():string {return jucf(function() {return ju_trim_text_left(
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
	jua(IV::getRootPackage(), 'pretty_version'), 'dev-'
);});}