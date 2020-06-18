<?php
use Closure as F;
use Justuno\Core\Exception as DFE;
use Magento\Config\Model\Config\Structure\AbstractElement as AE;
use Magento\Framework\DataObject as _DO;

/**
 * 2020-02-04
 * 2020-06-18 "Port the `df_gd` function": https://github.com/justuno-com/core/issues/76
 * @used-by ju_gd()
 * @param mixed $v
 * @return _DO|AE
 * @throws DFE
 */
function ju_assert_gd($v) {return df_has_gd($v) ? $v : ju_error(df_ucfirst(
	'%s does not support a proper getData().', df_type($v)
));}

/**
 * 2020-02-04
 * 2020-06-18 "Port the `df_gd` function": https://github.com/justuno-com/core/issues/74
 * @used-by juad()
 * @param mixed|_DO|AE $v
 * @param F|bool|mixed $onE [optional]
 * @return array(string => mixed)
 */
function ju_gd($v, $onE = true) {return ju_try(function() use($v) {return ju_assert_gd($v)->getData();}, $onE);}