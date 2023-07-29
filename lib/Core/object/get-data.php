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
 * 2020-06-18 "Port the `df_has_gd` function": https://github.com/justuno-com/core/issues/77
 * @used-by \Justuno\Core\Qa\Dumper::dumpObject()
 * @param mixed $v
 */
function ju_has_gd($v):bool {return $v instanceof _DO || $v instanceof AE;}