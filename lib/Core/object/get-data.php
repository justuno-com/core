<?php
use Closure as F;
use Justuno\Core\Exception as DFE;
use Magento\Config\Model\Config\Structure\AbstractElement as AE;
use Magento\Framework\DataObject as _DO;

/**
 * 2020-02-04
 * 2020-06-18 "Port the `df_gd` function": https://github.com/justuno-com/core/issues/74
 * @used-by juad()
 * @param mixed|_DO|AE $v
 * @param F|bool|mixed $onE [optional]
 * @return array(string => mixed)
 */
function ju_gd($v, $onE = true) {return df_try(function() use($v) {return df_assert_gd($v)->getData();}, $onE);}