<?php
/**
 * 2019-11-30
 * 2020-08-21 "Port the `df_table_exists` function" https://github.com/justuno-com/core/issues/229
 * @used-by \Justuno\M2\Setup\UpgradeSchema::tr()
 * @param string $t
 * @return bool
 */
function ju_table_exists($t) {return ju_conn()->isTableExists(df_table($t));}