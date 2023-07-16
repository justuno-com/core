<?php
/**
 * 2020-09-25, 2023-07-16
 * @used-by ju_log_l()
 * @return array(string => mixed)
 */
function ju_context():array {return
	['mage2pro/core' => ju_core_version(), 'Magento' => ju_magento_version(), 'PHP' => phpversion()]
	+ (ju_is_cli()
		? ['Command' => ju_cli_cmd()]
		: (['Referer' => ju_referer(), 'URL' => ju_current_url()] + (!ju_request_o()->isPost() ? [] : ['Post' => $_POST]))
	)
;}