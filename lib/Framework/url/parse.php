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
 * 2017-02-13 It removes the following endinds: «/», «index/», «index/index/».
 * 2021-03-07 "Port the `df_url_trim_index` function": https://github.com/justuno-com/core/issues/364
 * @used-by ju_url_frontend()
 * @param string $u
 * @return string
 */
function ju_url_trim_index($u) {
	# 2020-03-02
	# The square bracket syntax for array destructuring assignment (`[…] = […]`) requires PHP ≥ 7.1:
	# https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	# We should support PHP 7.0.
	list($base, $path) = df_url_bp($u); /** @var string $base */ /** @var string $path */
	$a = df_explode_path($path); /** @var string[] $a */
	$i = count($a) - 1; /** @var int $i */
	while ($a && in_array($a[$i--], ['', 'index'], true)) {array_pop($a);}
	return ju_cc_path($base, ju_cc_path($a));
}

/**
 * 2016-05-30
 * 2020-06-24 "Port the `df_zuri` function": https://github.com/justuno-com/core/issues/134
 * @used-by ju_domain()
 * @param string $u
 * @param F|bool|mixed $throw [optional]
 * @return zUri|zUriH|mixed
 * @throws E|zUriE
 */
function ju_zuri($u, $throw = true) {return ju_try(function() use($u) {return zUri::factory($u);}, $throw);}