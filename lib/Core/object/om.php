<?php
use Magento\Framework\App\ObjectManager as OM;
use Magento\Framework\ObjectManagerInterface as IOM;

/**
 * 2020-06-13 "Port the `df_o` function": https://github.com/justuno-com/core/issues/3
 * @used-by ju_app_state()
 * @used-by ju_backend_session()
 * @used-by ju_component_r()
 * @used-by ju_customer_session()
 * @used-by ju_fs()
 * @used-by ju_magento_version_m()
 * @used-by ju_module_dir_reader()
 * @used-by ju_request_o()
 * @used-by ju_scope_resolver_pool()
 * @used-by ju_store_cookie_m()
 * @used-by ju_store_m()
 * @used-by ju_visitor_ip()
 * @param string $t
 * @return mixed
 */
function ju_o($t) {return jucf(function($t) {return ju_om()->get($t);}, [$t]);}

/**
 * 2020-06-13 "Port the `df_om` function": https://github.com/justuno-com/core/issues/4
 * @used-by ju_o()
 * @return OM|IOM
 */
function ju_om() {return OM::getInstance();}