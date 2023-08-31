<?php
/**
 * 2020-09-25, 2023-07-16
 * @used-by ju_log_l()
 * @used-by \Justuno\Core\Qa\Failure\Error::preface()
 * @return array(string => mixed)
 */
function ju_context():array {return
	['justuno.com/core' => ju_core_version(), 'Magento' => ju_magento_version(), 'PHP' => phpversion()]
	+ (ju_is_cli()
		? ['Command' => ju_cli_cmd()]
		: ([
			'URL' => ju_current_url()
			,'Time' => ju_dts(null, 'y-MM-dd HH:mm:ss') # 2023-08-04 https://github.com/mage2pro/core/issues/312
			,'Referer' => ju_referer()
			# 2021-04-18 "Include the visitor's IP address to Mage2.PRO reports": https://github.com/mage2pro/core/issues/151
			,'IP Address' => ju_visitor_ip()
			# 2021-06-05 "Log the request method": https://github.com/mage2pro/core/issues/154
			,'Request Method' => ju_request_method()
			# 2021-04-18 "Include the visitor's `User-Agent` to Mage2.PRO reports": https://github.com/mage2pro/core/issues/152
			,'User-Agent' => ju_request_ua()
			] + (!ju_request_o()->isPost() ? [] : ju_clean([
				# 2021-10-20 "Log the `php://input` data": https://github.com/mage2pro/core/issues/162
				'php://input' => ju_request_body(), 'Post' => $_POST
			]))
		)
	)
;}