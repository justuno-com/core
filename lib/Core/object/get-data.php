<?php
use Closure as F;
use Justuno\Core\Exception as DFE;
use Magento\Config\Model\Config\Structure\AbstractElement as AE;
use Magento\Framework\DataObject as _DO;

/**
 * 2020-02-04
 * 2020-06-18 "Port the `df_has_gd` function": https://github.com/justuno-com/core/issues/77
 * @used-by \Justuno\Core\Qa\Dumper::dumpObject()
 * @param mixed $v
 */
function ju_has_gd($v):bool {return $v instanceof _DO || $v instanceof AE;}