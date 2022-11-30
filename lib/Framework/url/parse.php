<?php
use Closure as F;
use Exception as E;
use Zend_Uri as zUri;
use Zend_Uri_Exception as zUriE;
use Zend_Uri_Http as zUriH;

/**
 * 2017-05-12
 * 2020-06-24 "Port the `df_domain` function": https://github.com/justuno-com/core/issues/133
 * @used-by ju_domain_current()
 * @param string $u
 * @param bool $www [optional]
 * @param F|bool|mixed $throw [optional]
 * @return string|null
 * @throws E|zUriE
 */
function ju_domain($u, $www = false, $throw = true) {return
	!($r = ju_zuri($u, $throw)->getHost()) ? null : ($www ? $r : ju_trim_text_left($r, 'www.'))
;}

/**
 * 2016-05-30
 * 2020-06-24 "Port the `df_zuri` function": https://github.com/justuno-com/core/issues/134
 * @used-by ju_domain()
 * @used-by ju_url_bp()
 * @param string $u
 * @param F|bool|mixed $throw [optional]
 * @return zUri|zUriH|mixed
 * @throws E|zUriE
 */
function ju_zuri($u, $throw = true) {return ju_try(function() use($u) {return zUri::factory($u);}, $throw);}