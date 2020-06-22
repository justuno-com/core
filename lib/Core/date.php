<?php
use DateTime as DT;
use DateTimeZone as DTZ;
use Magento\Framework\App\ScopeInterface as ScopeA;
use Magento\Store\Model\Store;
use Zend_Date as ZD;
/**
 * 2016-07-19
 * 2020-06-22 "Port the `df_date` function": https://github.com/justuno-com/core/issues/114
 * @used-by ju_dts()
 * @param Zend_Date|null $date [optional]
 * @return Zend_Date
 */
function ju_date(ZD $date = null) {return $date ?: ZD::now();}

/**
 * 2015-02-07
 * 2020-06-22 "Port the `df_dts` function": https://github.com/justuno-com/core/issues/105
 * @used-by ju_file_name()
 * @param ZD|null $date [optional]
 * @param string|null $format [optional]
 * @param Zend_Locale|string|null $locale [optional]
 * @return string
 */
function ju_dts(ZD $date = null, $format = null, $locale = null) {return ju_result_sne(
	ju_date($date)->toString($format, $type = null, $locale)
);}