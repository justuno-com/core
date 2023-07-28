<?php
/**
 * «Dfe\AllPay\W\Handler» => «Dfe_AllPay»
 *
 * 2016-10-26
 * The function correctly handles class names without a namespace and with the `_` character:
 * «A\B\C» => «A_B»
 * «A_B» => «A_B»
 * «A» => A»
 * https://3v4l.org/Jstvc
 *
 * 2017-01-27
 * $c could be:
 * 1) a module name: «A_B»
 * 2) a class name: «A\B\C».
 * 3) an object: it comes down to the case 2 via @see get_class()
 * 4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 *
 * 2020-06-26 "Port the `ju_module_name` function": https://github.com/justuno-com/core/issues/138
 *
 * @used-by ju_asset_name()
 * @used-by ju_fe_init()
 * @used-by ju_js_x()
 * @used-by ju_module_dir()
 * @used-by ju_module_name_c()
 * @used-by ju_package()
 * @used-by ju_sentry_module()
 * @used-by ju_x_module()
 * @used-by \Justuno\M2\Plugin\Framework\App\Router\ActionList::aroundGet()
 * @param string|object|null $c [optional]
 */
function ju_module_name($c = null, string $d = '_'):string {return jucf(
	function(string $c, string $d) {return implode($d, array_slice(ju_explode_class($c), 0, 2));}
	,[$c ? ju_cts($c) : 'Justuno\Core', $d]
);}

/**
 * 2023-07-26
 * "If `df_log()` is called from a `*.phtml`,
 * then the `*.phtml`'s module should be used as the log source instead of `Magento_Framework`":
 * https://github.com/mage2pro/core/issues/268
 * @used-by ju_caller_module()
 */
function ju_module_name_by_path(string $f):string {/** @var string $r */
	$f = ju_path_relative($f);
	$f2 = ju_trim_text_left($f, ['app/code/', 'vendor/']);
	$err = "Unable to detect the module for the file: `$f`"; /** @var string $err */
	ju_assert_ne($f, $f2, $err);
	$isVendor = ju_starts_with($f, 'vendor'); /** @var bool $isVendor */
	$a = array_slice(ju_explode_xpath($f2), 0, 2); /** @var string[] $a */
	ju_assert_eq(2, count($a), $err);
	if (!$isVendor) {
		$r = implode('_', $a);
	}
	else {
		$p = ju_cc_path('vendor', $a, 'etc/module.xml');
		# 2023-07-26 "`df_contents()` should accept internal paths": https://github.com/mage2pro/core/issues/273
		$x = ju_xml_parse(ju_contents($p));
		$r = (string)$x->{'module'}['name'];
	}
	return $r;
}

/**
 * 2017-01-04
 * $c could be:
 * 		1) a module name. E.g.: «A_B».
 * 		2) a class name. E.g.: «A\B\C».
 * 		3) an object. It will be treated as case 2 after @see get_class()
 * 2020-08-21 "Port the `df_module_name_c` function" https://github.com/justuno-com/core/issues/218
 * @used-by ju_module_name_lc()
 * @param string|object|null $c [optional]
 */
function ju_module_name_c($c = null):string {return ju_module_name($c, '\\');}

/**
 * 2016-02-16 «Dfe\CheckoutCom\Method» => «dfe_checkout_com»
 * 2016-10-20
 * Making $c optional leads to the error «get_class() called without object from outside a class»: https://3v4l.org/k6Hd5
 * 2017-10-03
 * $c could be:
 * 		1) a module name. E.g.: «A_B».
 * 		2) a class name. E.g.: «A\B\C».
 * 		3) an object. It will be treated as case 2 after @see get_class()
 * 2020-08-21 "Port the `df_module_name_lc` function" https://github.com/justuno-com/core/issues/216
 * @used-by ju_report_prefix()
 * @used-by \Justuno\Core\Exception::reportNamePrefix()
 * @param string|object $c
 */
function ju_module_name_lc($c, string $d = '_'):string {return implode($d, ju_explode_class_lc_camel(ju_module_name_c($c)));}