<?php
use Magento\Framework\App\ResourceConnection as RC;
use Magento\Framework\DB\Adapter\AdapterInterface as IAdapter;
use Magento\Framework\DB\Adapter\Pdo\Mysql;
use Magento\Framework\DB\Ddl\Trigger;
use Magento\Framework\DB\Select;
use Magento\Framework\DB\Transaction;

/**
 * 2020-08-14 "Port the `df_conn` function" https://github.com/justuno-com/core/issues/191
 * @used-by ju_db_version()
 * @return Mysql|IAdapter
 */
function ju_conn() {return df_db_resource()->getConnection();}