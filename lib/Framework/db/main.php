<?php
/**
 * 2016-12-23 http://stackoverflow.com/a/10414925
 * 2020-08-14 "Port the `df_db_version` function" https://github.com/justuno-com/core/issues/190
 * @used-by ju_sentry_m()
 * @see \Magento\Backup\Model\ResourceModel\Helper::getHeader()
 * https://github.com/magento/magento2/blob/2.1.3/app/code/Magento/Backup/Model/ResourceModel/Helper.php#L178
 * @return string
 */
function ju_db_version() {return jucf(function() {return df_conn()->fetchRow("SHOW VARIABLES LIKE 'version'")['Value'];});}