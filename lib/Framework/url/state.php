<?php
use Magento\Store\Api\Data\StoreInterface as IStore;
/**
 * http://mage2.ru/t/37
 * 2020-08-21 "Port the `df_current_url` function" https://github.com/justuno-com/core/issues/212
 * @used-by ju_context()
 * @used-by \Justuno\Core\Sentry\Client::get_http_data()
 */
function ju_current_url():string {return ju_url_o()->getCurrentUrl();}

/**
 * 2016-03-09
 * I have ported it from my «Russian Magento» product for Magento 1.x: http://magento-forum.ru
 * @uses df_store_url_web() returns an empty string
 * if the store's root URL is absent in the Magento database.
 * 2017-03-15
 * It returns null only if the both conditions are true:
 * 1) Magento runs from the command line (by Cron or in console).
 * 2) The store's root URL is absent in the Magento database.
 * 2020-06-24 "Port the `df_domain_current` function": https://github.com/justuno-com/core/issues/119
 * @used-by ju_sentry()
 * @param int|string|null|bool|IStore $s [optional]
 * @return string|null
 */
function ju_domain_current($s = null, bool $www = false) {return jucf(function($s = null, bool $www = false) {return
	!($base = ju_store_url_web($s)) || !($r = ju_domain($base, false)) ? null : (
		$www ? $r : ju_trim_text_left($r, 'www.')
	)
;}, func_get_args());}