<?php
use Composer\InstalledVersions as IV;
use Magento\Framework\App\State;
/**
 * 2023-07-15
 * @used-by ju_sentry_m()
 */
function ju_api_version():int {return 'm2' === ju_package_name_l('Justuno_M2') ? 3 : 4;}

/**
 * 2015-09-20
 * 2020-06-24 "Port the `df_app_state` function": https://github.com/justuno-com/core/issues/128
 * @used-by ju_area_code()
 */
function ju_app_state():State {return ju_o(State::class);}

/**
 * https://mage2.ru/t/94
 * https://mage2.pro/t/59
 * 2020-06-24 "Port the `df_is_ajax` function": https://github.com/justuno-com/core/issues/129
 * @used-by ju_is_backend()
 * @used-by ju_is_frontend()
 */
function ju_is_ajax():bool {static $r; return !is_null($r) ? $r : $r = ju_request_o()->isXmlHttpRequest();}

/**
 * 2016-05-15 http://stackoverflow.com/a/2053295
 * 2017-06-09 It intentionally returns false in the CLI mode.
 * 2020-08-14 "Port the `df_is_localhost` function" https://github.com/justuno-com/core/issues/186
 * @used-by ju_my_local()
 */
function ju_is_localhost():bool {return in_array(jua($_SERVER, 'REMOTE_ADDR', []), ['127.0.0.1', '::1']);}

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

/**
 * 2017-04-17
 * @used-by ju_my_local()
 */
function ju_my():bool {return isset($_SERVER['DF_DEVELOPER']);}

/**
 * 2017-06-09 «dfediuk» is the CLI user name on my localhost.
 * 2020-08-14 "Port the `df_my_local` function" https://github.com/justuno-com/core/issues/184
 * @used-by ju_visitor_ip()
 * @used-by \Justuno\M2\Store::v()
 */
function ju_my_local():bool {return jucf(function() {return
	ju_my() && (ju_is_localhost() || 'dfediuk' === jua($_SERVER, 'USERNAME'))
;});}