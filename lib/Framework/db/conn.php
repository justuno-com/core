<?php
use Magento\Framework\App\ResourceConnection as RC;
use Magento\Framework\DB\Adapter\AdapterInterface as IAdapter;
use Magento\Framework\DB\Adapter\Pdo\Mysql;

/**
 * 2020-08-14 "Port the `df_conn` function" https://github.com/justuno-com/core/issues/191
 * @used-by ju_db_version()
 * @used-by ju_fetch()
 * @used-by ju_fetch_col()
 * @used-by ju_fetch_one()
 * @used-by ju_select()
 * @used-by ju_table_exists()
 * @used-by \Justuno\M2\Store::v()
 * @used-by \Justuno\M2\Setup\UpgradeSchema::tr()
 * @return Mysql|IAdapter
 */
function ju_conn(string $n = RC::DEFAULT_CONNECTION) {return ju_db_resource()->getConnection($n);}
