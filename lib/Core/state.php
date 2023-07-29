<?php
use Magento\Framework\App\State;

/**
 * 2023-07-15
 * @used-by ju_sentry_m()
 */
function ju_api_version():int {return 'm2' === ju_package_name_l('Justuno_M2') ? 3 : 4;}

/**
 * 2015-09-20
 * 2020-06-24 "Port the `df_app_state` function": https://github.com/justuno-com/core/issues/128
 * @used-by ju_area_code()
 */
function ju_app_state():State {return ju_o(State::class);}

/**
 * https://mage2.ru/t/94
 * https://mage2.pro/t/59
 * 2020-06-24 "Port the `df_is_ajax` function": https://github.com/justuno-com/core/issues/129
 * @used-by ju_is_backend()
 * @used-by ju_is_frontend()
 */
function ju_is_ajax():bool {static $r; return !is_null($r) ? $r : $r = ju_request_o()->isXmlHttpRequest();}

/**
 * 2016-05-15 http://stackoverflow.com/a/2053295
 * 2017-06-09 It intentionally returns false in the CLI mode.
 * 2020-08-14 "Port the `df_is_localhost` function" https://github.com/justuno-com/core/issues/186
 * @used-by ju_my_local()
 */
function ju_is_localhost():bool {return in_array(jua($_SERVER, 'REMOTE_ADDR', []), ['127.0.0.1', '::1']);}

/**
 * 2017-04-17
 * @used-by ju_my_local()
 */
function ju_my():bool {return isset($_SERVER['DF_DEVELOPER']);}

/**
 * 2017-06-09 «dfediuk» is the CLI user name on my localhost.
 * 2020-08-14 "Port the `df_my_local` function" https://github.com/justuno-com/core/issues/184
 * @used-by ju_visitor_ip()
 * @used-by \Justuno\M2\Store::v()
 */
function ju_my_local():bool {return jucf(function() {return
	ju_my() && (ju_is_localhost() || 'dfediuk' === jua($_SERVER, 'USERNAME'))
;});}