<?php
/**
 * 2016-12-25
 * 2017-02-18 Модуль Checkout.com раньше использовал dfa($_SERVER, 'HTTP_USER_AGENT')
 * @used-by ju_context()
 * @used-by \Justuno\M2\Response::p()
 * @return string|bool
 */
function ju_request_ua(string ...$s) {
	$r = ju_request_header('user-agent'); /** @var string $r */
	return !$s ? $r : ju_contains($r, ...$s);
}