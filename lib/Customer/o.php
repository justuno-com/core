<?php
use Magento\Customer\Model\CustomerRegistry;
/**
 * 2016-04-05
 * 2020-08-14 "Port the `df_customer_registry` function" https://github.com/justuno-com/core/issues/189
 * @used-by ju_customer()
 */
function ju_customer_registry():CustomerRegistry {return ju_o(CustomerRegistry::class);}
