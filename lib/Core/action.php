<?php
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