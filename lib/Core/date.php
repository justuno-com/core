<?php
use Zend_Date as ZD;
/**
 * 2016-07-19
 * 2020-06-22 "Port the `df_date` function": https://github.com/justuno-com/core/issues/114
 * @used-by ju_dts()
 */
function ju_date(ZD $d = null):ZD {return $d ?: ZD::now();}

/**
 * @used-by \Justuno\M2\Catalog\Diagnostic::p()
 * @return ZD|null
 * @throws Exception
 */
function ju_date_from_db(string $s, bool $onE = true) {
	ju_param_sne($s, 0); return ju_try(function() use($s):ZD {return new ZD($s, ZD::ISO_8601);}, $onE);
}

/**
 * 2016-07-19
 * @used-by \Justuno\M2\Catalog\Diagnostic::p()
 * @param ZD $d1
 * @param ZD $d2
 * @return bool
 */
function ju_date_lt(ZD $d1, ZD $d2) {return $d1->getTimestamp() < $d2->getTimestamp();}

/**
 * 2015-02-07
 * 2020-06-22 "Port the `df_dts` function": https://github.com/justuno-com/core/issues/105
 * @used-by ju_file_name()
 * @param string|null $fmt [optional]
 * @param Zend_Locale|string|null $l [optional]
 */
function ju_dts(ZD $date = null, $fmt = null, $l = null):string {return ju_result_sne(ju_date($date)->toString($fmt, null, $l));}