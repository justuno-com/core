<?php
use Closure as F;
use Magento\Framework\App\Area as A;

/**
 * 2017-04-02 «Area code is not set» on a df_area_code_is() call: https://mage2.pro/t/3581
 * 2020-06-24 "Port the `df_area_code` function": https://github.com/justuno-com/core/issues/127
 * @used-by ju_area_code_is()
 * @param F|bool|mixed $onE [optional]
 * @return string|null
 * @throws Exception
 */
function ju_area_code($onE = null) {return ju_try(function() {return ju_app_state()->getAreaCode();}, $onE);}

/**
 * 2016-09-30
 * 2017-04-02 «Area code is not set» on a df_area_code_is() call: https://mage2.pro/t/3581
 * 2020-06-24 "Port the `df_area_code_is` function": https://github.com/justuno-com/core/issues/126
 * @used-by ju_is_backend()
 * @used-by ju_is_frontend()
 * @used-by ju_is_rest()
 */
function ju_area_code_is(string ...$v):bool {return in_array(ju_area_code(), $v);}

/**
 * 2015-08-14
 * 2020-06-24 "Port the `df_is_backend` function": https://github.com/justuno-com/core/issues/125
 * @used-by ju_block()
 * @used-by ju_catalog_locator()
 * @used-by ju_customer_id()
 * @used-by ju_product_current()
 * @used-by ju_store()
 * @used-by \Justuno\Core\Config\Settings::scope()
 */
function ju_is_backend():bool {return ju_area_code_is(A::AREA_ADMINHTML) || ju_is_ajax() && ju_backend_user();}

/**
 * 2016-06-02 By analogy with @see ju_is_backend()
 * 2016-09-30
 * Today I have noticed that @uses \Magento\Framework\App\State::getAreaCode()
 * returns @see \Magento\Framework\App\Area::AREA_WEBAPI_REST during a frontend payment.
 * 2016-09-30
 * The used constant is available since Magento 2.0.0:
 * https://github.com/magento/magento2/blob/2.0.0/lib/internal/Magento/Framework/App/Area.php
 * 2020-08-13 "Port the `df_is_frontend` function" https://github.com/justuno-com/core/issues/179
 * @used-by ju_sentry_m()
 */
function ju_is_frontend():bool {return ju_area_code_is(A::AREA_FRONTEND) || ju_is_ajax() && ju_customer_session_id();}

/**
 * 2017-03-15
 * @see ju_is_ajax()
 * @see ju_is_backend()
 * @see ju_is_frontend()
 * @used-by ju_response()
 */
function ju_is_rest():bool {return ju_area_code_is(A::AREA_WEBAPI_REST);}