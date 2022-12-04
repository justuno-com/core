<?php
use Magento\Customer\Model\CustomerRegistry;
use Magento\Customer\Model\Session;
/**
 * 2016-04-05
 * 2020-08-14 "Port the `df_customer_registry` function" https://github.com/justuno-com/core/issues/189
 * @used-by ju_customer()
 */
function ju_customer_registry():CustomerRegistry {return ju_o(CustomerRegistry::class);}

/**
 * 2020-08-14 "Port the `df_customer_session` function" https://github.com/justuno-com/core/issues/182
 * @used-by ju_customer()
 * @used-by ju_customer_id()
 * @used-by ju_customer_session_id()
 */
function ju_customer_session():Session {return ju_o(Session::class);}
