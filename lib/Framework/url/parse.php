<?php
use Closure as F;
use Throwable as Th; # 2023-08-30 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401
use Zend_Uri as zUri;
use Zend_Uri_Exception as zUriE;
use Zend_Uri_Http as zUriH;

/**
 * 2017-05-12
 * 2020-06-24 "Port the `df_domain` function": https://github.com/justuno-com/core/issues/133
 * @used-by ju_domain_current()
 * @param F|bool|mixed $throw [optional]
 * @return string|null
 * @throws Th|zUriE
 */
function ju_domain(string $u, bool $www = false, $throw = true) {return
	!($r = ju_zuri($u, $throw)->getHost()) ? null : ($www ? $r : ju_trim_text_left($r, 'www.'))
;}

/**
 * 2016-05-30
 * 2020-06-24 "Port the `df_zuri` function": https://github.com/justuno-com/core/issues/134
 * @used-by ju_domain()
 * @param F|bool|mixed $throw [optional]
 * @return zUri|zUriH|mixed
 * @throws E|zUriE
 */
function ju_zuri(string $u, $throw = true) {return ju_try(function() use($u) {return zUri::factory($u);}, $throw);}