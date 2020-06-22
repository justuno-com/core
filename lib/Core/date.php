<?php
use DateTime as DT;
use DateTimeZone as DTZ;
use Magento\Framework\App\ScopeInterface as ScopeA;
use Magento\Store\Model\Store;
use Zend_Date as ZD;
/**
 * 2015-02-07
 * 2020-06-22 "Port the `df_dts` function": https://github.com/justuno-com/core/issues/105
 * @used-by ju_file_name()
 * @param ZD|null $date [optional]
 * @param string|null $format [optional]
 * @param Zend_Locale|string|null $locale [optional]
 * @return string
 */
function ju_dts(ZD $date = null, $format = null, $locale = null) {return df_result_sne(
	df_date($date)->toString($format, $type = null, $locale)
);}