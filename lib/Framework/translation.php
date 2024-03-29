<?php
/**
 * 2017-02-09
 * It does the same as @see \Magento\Framework\Filter\TranslitUrl::filter(), but without lower-casing:
 * '歐付寶 all/Pay' => 'all-Pay'
 * If you need lower-casing, then use @see df_translit_url_lc() instead.
 * 2020-08-13 "Port the `df_translit_url` function" https://github.com/justuno-com/core/issues/168
 * Example #1: '歐付寶 all/Pay':
 * 		@see df_fs_name => 歐付寶-allPay
 * 		@see ju_translit =>  all/Pay
 * 		@see ju_translit_url => all-Pay
 * 		@see df_translit_url_lc => all-pay
 * Example #2: '歐付寶 O'Pay (allPay)':
 * 		@see df_fs_name => 歐付寶-allPay
 * 		@see ju_translit =>  allPay
 * 		@see ju_translit_url => allPay
 * 		@see df_translit_url_lc => allpay
 * @used-by \Justuno\Core\Sentry\Client::tags()
 */
function ju_translit_url(string $s):string {return trim(preg_replace('#[^0-9a-z]+#i', '-', ju_translit($s)), '-');}