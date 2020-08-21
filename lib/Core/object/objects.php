<?php
use Magento\Framework\DataObject as _DO;

/**
 * 2016-01-06
 * 2017-01-12 Use @see df_new() if you do not need Object Manager.
 * 2020-08-21 "Port the `ju_new_om` function" https://github.com/justuno-com/core/issues/232
 * @see df_new_omd()
 * @used-by ju_trigger()
 * @param string $c
 * @param array(string => mixed) $p [optional]
 * @return _DO|object
 */
function ju_new_om($c, array $p = []) {return ju_om()->create($c, $p);}