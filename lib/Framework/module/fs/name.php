<?php
use Closure as F;
use Magento\Framework\Module\Dir;

/**
 * 2015-08-14
 * https://mage2.pro/t/57
 * https://mage2.ru/t/92
 * 2015-09-02
 * @uses \Magento\Framework\Module\Dir\Reader::getModuleDir()
 * uses `/` insteads @see DIRECTORY_SEPARATOR as the path separator, so I use `/` too.
 * 2016-11-17
 * 1) $m could be:
 * 		1.1) a module name: «A_B»
 * 		1.2) a class name: «A\B\C».
 * 		1.3) an object: it comes down to the case 2 via @see get_class()
 * 		1.4) `null`: it comes down to the case 1 with the «Df_Core» module name.
 * 2) The function does not cache its result because is is already cached by
 * @uses \Magento\Framework\Module\Dir\Reader::getModuleDir().
 * 2019-12-31
 * 1) The result is the full filesystem path of the module, e.g.
 * «C:/work/clients/royalwholesalecandy.com-2019-12-08/code/vendor/mage2pro/core/Intl».
 * 2) The allowed $type argument values are:
 * @see \Magento\Framework\Module\Dir::MODULE_ETC_DIR
 * @see \Magento\Framework\Module\Dir::MODULE_I18N_DIR
 * @see \Magento\Framework\Module\Dir::MODULE_VIEW_DIR
 * @see \Magento\Framework\Module\Dir::MODULE_CONTROLLER_DIR
 * @see \Magento\Framework\Module\Dir::getDir():
 *	if ($type) {
 *		if (!in_array($type, [
 *			self::MODULE_ETC_DIR,
 *			self::MODULE_I18N_DIR,
 *			self::MODULE_VIEW_DIR,
 *			self::MODULE_CONTROLLER_DIR
 *		])) {
 *		throw new \InvalidArgumentException("Directory type '{$type}' is not recognized.");
 *	}
 *		$path .= '/' . $type;
 *	}
 * https://github.com/magento/magento2/blob/2.3.3/lib/internal/Magento/Framework/Module/Dir.php#L54-L65
 * 2020-06-26 "Port the `df_module_dir` function": https://github.com/justuno-com/core/issues/147
 * @used-by ju_module_path()
 * @used-by ju_module_path_etc()
 * @param string|object|null $m
 * @throws InvalidArgumentException
 */
function ju_module_dir($m, string $type = ''):string {
	if ('Magento_Framework' !== ($m = ju_module_name($m))) {
		$r = ju_module_dir_reader()->getModuleDir($type, $m);
	}
	else {
		$r = ju_framework_path();
		# 2019-12-31 'Magento_Framework' is not a module, so it does not have subpaths specific for modules.
		# 2023-07-26
		# "Implement a meaningful message for `df_assert` in `df_module_dir()`":
		# https://github.com/mage2pro/core/issues/266
		ju_assert(!$type, "`Magento_Framework` is not a module, so it does not have subpaths specific for modules.");
	}
	return $r;
}

/**
 * 2023-01-28
 * $m could be:
 * 		1) a module name: «A_B»
 * 		2) a class name: «A\B\C».
 * 		3) an object: it comes down to the case 2 via @see get_class()
 * 		4) `null`: it comes down to the case 1 with the «Df_Core» module name.
 * 2023-07-26
 * `df_sentry_m()` fails: «`Magento_Framework` is not a module, so it does not have subpaths specific for modules»:
 * https://github.com/mage2pro/core/issues/267
 * @used-by ju_module_file_read()
 * @param string|object|null $m
 * @param F|bool|mixed $onE [optional]
 */
function ju_module_file_name($m, string $name, string $ext = '', $onE = true):string {return ju_fts(ju_try(
	function() use($m, $name, $ext):string {
		$r = ju_module_path_etc($m, ju_file_ext_add($name, $ext));
		ju_assert(file_exists($r), "The required file «{$r}» is absent."); return $r;
	}, $onE
));}

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
 * 2015-11-15
 * 2015-09-02
 * @uses ju_module_dir() and indirectly called @see \Magento\Framework\Module\Dir\Reader::getModuleDir()
 * use `/` insteads @see DIRECTORY_SEPARATOR as a path separator, so I use `/` too.
 * 2016-11-17
 * $m could be:
 * 		1) a module name: «A_B»
 * 		2) a class name: «A\B\C».
 * 		3) an object: it comes down to the case 2 via @see get_class()
 * 		4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2020-06-26 "Port the `df_module_path` function": https://github.com/justuno-com/core/issues/146
 * @used-by ju_package()
 * @param string|object|null $m
 * @throws InvalidArgumentException
 */
function ju_module_path($m, string $localPath = ''):string {return ju_cc_path(ju_module_dir($m), $localPath);}

/**
 * 2016-07-19
 * 2015-09-02
 * @uses ju_module_dir() and indirectly called @see \Magento\Framework\Module\Dir\Reader::getModuleDir()
 * use `/` insteads @see DIRECTORY_SEPARATOR as the path separator, so I use `/` too.
 * 2016-11-17
 * $m could be:
 * 		1) a module name: «A_B»
 * 		2) a class name: «A\B\C».
 * 		3) an object: it comes down to the case 2 via @see get_class()
 * 		4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2020-06-27 "Port the `df_module_path_etc` function": https://github.com/justuno-com/core/issues/164
 * @used-by ju_module_file_name()
 * @param string|object|null $m
 * @throws InvalidArgumentException
 */
function ju_module_path_etc($m, string $localPath = ''):string {return ju_cc_path(
	ju_module_dir($m, Dir::MODULE_ETC_DIR), $localPath
);}