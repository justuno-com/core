<?php
use Magento\Framework\DB\Select as S;

/**
 * 2019-11-15
 * 2020-08-22 "Port the `ju_fetch` function" https://github.com/justuno-com/core/issues/266
 * @used-by \Justuno\M2\Source\Brand::map()
 * @param string $t
 * @param string|string[] $cols [optional]
 * @param string|null $compareK [optional]
 * @param int|string|int[]|string[]|null $compareV [optional]
 * @return array(array(string => string))
 */
function ju_fetch($t, $cols = '*', $compareK = null, $compareV = null) {
	$s = ju_db_from($t, $cols); /** @var S $s */
	if (!is_null($compareV)) {
		$s->where($compareK . ' ' . ju_sql_predicate_simple($compareV), $compareV);
	}
	return ju_conn()->fetchAll($s);
}

/**
 * 2015-11-03
 * 2020-08-24 "Port the `df_fetch_one` function" https://github.com/justuno-com/core/issues/327
 * @used-by \Justuno\M2\Controller\Response\Orders::stat()
 * @param string $t
 * @param string|string[] $cols
 * @param array(string => string) $compare
 * @return string|null|array(string => mixed)
 */
function ju_fetch_one($t, $cols, $compare) {
	$s = ju_db_from($t, $cols); /** @var S $s */
	foreach ($compare as $c => $v) {/** @var string $c */ /** @var string $v */
		$s->where('? = ' . $c, $v);
	}
	/**
	 * 2016-03-01
	 * @uses \Zend_Db_Adapter_Abstract::fetchOne() возвращает false при пустом результате запроса.
	 * https://mage2.pro/t/853
	 */
	return '*' !== $cols ? ju_ftn(ju_conn()->fetchOne($s)) : df_eta(ju_conn()->fetchRow($s, [], \Zend_Db::FETCH_ASSOC));
}