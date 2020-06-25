<?php
use Magento\Framework\Config\Composer\Package;

/**
 * 2017-01-25
 * 2020-06-26 "Port the `df_core_version` function": https://github.com/justuno-com/core/issues/143
 * @used-by ju_sentry()
 * @return string
 */
function ju_core_version() {return jucf(function() {return df_package_version('Justuno_Core');});}