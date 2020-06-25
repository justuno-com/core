<?php
use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;

/**
 * 2015-08-14
 * https://mage2.pro/t/57
 * https://mage2.ru/t/92
 *
 * 2015-09-02
 * @uses \Magento\Framework\Module\Dir\Reader::getModuleDir()
 * uses `/` insteads @see DIRECTORY_SEPARATOR as a path separator, so I use `/` too.
 *
 * 2016-11-17
 * 1) $m could be:
 * 1.1) a module name: «A_B»
 * 1.2) a class name: «A\B\C».
 * 1.3) an object: it comes down to the case 2 via @see get_class()
 * 1.4) `null`: it comes down to the case 1 with the «Df_Core» module name.
 * 2) The function does not cache its result because is is already cached by
 * @uses \Magento\Framework\Module\Dir\Reader::getModuleDir().
 *
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
 *
 * 2020-06-26 "Port the `df_module_dir` function": https://github.com/justuno-com/core/issues/147
 *
 * @used-by ju_module_path()
 * @param string|object|null $m
 * @param string $type [optional]
 * @return string
 * @throws \InvalidArgumentException
 */
function ju_module_dir($m, $type = '') {
	if ('Magento_Framework' !== ($m = df_module_name($m))) {
		$r = df_module_dir_reader()->getModuleDir($type, $m);
	}
	else {
		$r = df_framework_path();
		// 2019-12-31 'Magento_Framework' is not a module, so it does not have subpaths specific for modules.
		ju_assert(!$type);
	}
	return $r;
}

/**
 * 2015-11-15
 * 2015-09-02
 * @uses df_module_dir() and indirectly called @see \Magento\Framework\Module\Dir\Reader::getModuleDir()
 * use `/` insteads @see DIRECTORY_SEPARATOR as a path separator, so I use `/` too.
 * 2016-11-17
 * $m could be:
 * 1) a module name: «A_B»
 * 2) a class name: «A\B\C».
 * 3) an object: it comes down to the case 2 via @see get_class()
 * 4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2020-06-26 "Port the `df_module_path` function": https://github.com/justuno-com/core/issues/146
 * @used-by ju_package()
 * @param string|object|null $m
 * @param string $localPath [optional]
 * @return string
 * @throws \InvalidArgumentException
 */
function ju_module_path($m, $localPath = '') {return ju_cc_path(ju_module_dir($m), $localPath);}