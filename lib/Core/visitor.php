<?php
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress as RA;

/**
 * 2020-08-14 "Port the `df_visitor_ip` function" https://github.com/justuno-com/core/issues/183
 * @used-by ju_sentry_m()
 */
function ju_visitor_ip():string {
	/** @var RA $a */ $a = ju_o(RA::class);
	# 2021-06-11
	# 1) «Ensure that the Customer IP address is being passed in the API request for all transactions»:
	# https://github.com/canadasatellite-ca/site/issues/175
	# 2) https://stackoverflow.com/a/14985633
	return ju_my_local() ? '158.181.235.66' : jua($_SERVER, 'HTTP_CF_CONNECTING_IP', $a->getRemoteAddress());
}