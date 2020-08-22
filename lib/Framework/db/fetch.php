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
		$s->where($compareK . ' ' . df_sql_predicate_simple($compareV), $compareV);
	}
	return ju_conn()->fetchAll($s);
}