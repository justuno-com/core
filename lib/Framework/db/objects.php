<?php
use Magento\Framework\App\ResourceConnection as RC;
use Magento\Framework\DB\Adapter\AdapterInterface as IAdapter;
use Magento\Framework\DB\Adapter\Pdo\Mysql;
use Magento\Framework\DB\Ddl\Trigger;

/**
 * 2020-08-14 "Port the `df_conn` function" https://github.com/justuno-com/core/issues/191
 * @used-by ju_db_version()
 * @used-by ju_table_exists()
 * @used-by \Justuno\M2\Setup\UpgradeSchema::tr()
 * @return Mysql|IAdapter
 */
function ju_conn() {return ju_db_resource()->getConnection();}

/**
 * 2015-09-29
 * 2020-08-14 "Port the `df_db_resource` function" https://github.com/justuno-com/core/issues/192
 * @used-by ju_conn()
 * @used-by ju_table()
 * @return RC
 */
function ju_db_resource() {return ju_o(RC::class);}

/**
 * 2019-11-22
 * 2020-08-21 "Port the `df_trigger` function" https://github.com/justuno-com/core/issues/231
 * @used-by \Justuno\M2\Setup\UpgradeSchema::tr()
 * @return Trigger
 */
function ju_trigger() {return ju_new_om(Trigger::class);}