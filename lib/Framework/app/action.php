<?php
/**
 * 2015-09-02
 * 2017-03-15 @uses \Magento\Framework\App\Request\Http::getFullActionName() returns «__» in the CLI case.
 * 2020-08-24 "Port the `df_action_name` function" https://github.com/justuno-com/core/issues/304
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @return string|null
 */
function ju_action_name() {return ju_is_cli() ? null : ju_request_o()->getFullActionName();}

/**
 * 2019-12-26
 * 2020-08-21 "Port the `df_referer` function" https://github.com/justuno-com/core/issues/211
 * @see \Magento\Store\App\Response\Redirect::getRefererUrl():
 * 		df_response_redirect()->getRefererUrl()
 * @used-by ju_log_l()
 * @used-by https://github.com/royalwholesalecandy/core/issues/58#issuecomment-569049731
 * @return string
 */
function ju_referer() {return jua($_SERVER, 'HTTP_REFERER');}