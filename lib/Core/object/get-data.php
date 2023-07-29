<?php
use Closure as F;
use Justuno\Core\Exception as DFE;
use Magento\Config\Model\Config\Structure\AbstractElement as AE;
use Magento\Framework\Api\AbstractSimpleObject as oAPI;
use Magento\Framework\DataObject as _DO;

/**
 * 2020-02-04
 * @used-by ju_gd()
 * @param mixed $v
 * @return _DO|AE|oAPI
 * @throws DFE
 */
function ju_assert_gd($v) {return ju_has_gd($v) ? $v : ju_error(ju_ucfirst(
	'Getting data from %s is not supported by `ju_gd()`.', ju_type($v)
));}

/**
 * 2020-02-04
 * @used-by \Justuno\Core\Qa\Dumper::dumpObject()
 * @used-by \Justuno\Core\Sentry\Extra::adjust()
 * @param mixed|_DO|AE|oAPI $v
 * @param F|bool|mixed $onE [optional]
 * @return array(string => mixed)
 */
function ju_gd($v, $onE = true):array {return ju_try(function() use($v) {return
	# 2023-07-28
	# "`df_gd()` / `df_has_gd()` / `df_assert_gd` should treat `Magento\Framework\Api\AbstractSimpleObject`
	# similar to `Magento\Framework\DataObject`": https://github.com/mage2pro/core/issues/290
	ju_is_api_o(ju_assert_gd($v)) ? $v->__toArray() : $v->getData()
;}, $onE);}

/**
 * 2020-02-04
 * 2020-06-18 "Port the `df_has_gd` function": https://github.com/justuno-com/core/issues/77
 * @used-by ju_assert_gd()
 * @used-by \Justuno\Core\Qa\Dumper::dumpObject()
 * @used-by \Justuno\Core\Sentry\Extra::adjust()
 * @param mixed $v
 */
function ju_has_gd($v):bool {return $v instanceof _DO || $v instanceof AE || ju_is_api_o($v);}