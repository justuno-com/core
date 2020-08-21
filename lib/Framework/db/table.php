<?php
/**
 * 2020-08-21 "Port the `df_table_exists` function" https://github.com/justuno-com/core/issues/230
 * @used-by ju_table_exists()
 * @used-by \Justuno\M2\Setup\UpgradeSchema::tr()
 * @param string|string[] $n
 * @return string
 */
function ju_table($n) {return jucf(function($n) {return ju_db_resource()->getTableName($n);}, [$n]);}

/**
 * 2019-11-30
 * 2020-08-21 "Port the `df_table_exists` function" https://github.com/justuno-com/core/issues/229
 * @used-by \Justuno\M2\Setup\UpgradeSchema::tr()
 * @param string $t
 * @return bool
 */
function ju_table_exists($t) {return ju_conn()->isTableExists(ju_table($t));}