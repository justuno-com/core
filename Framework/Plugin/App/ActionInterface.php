<?php
namespace Justuno\Core\Framework\Plugin\App;
use Magento\Framework\App\ActionInterface as Sb;
use Magento\Framework\Config\ConfigOptionsListConstants as C;
# 2021-02-23 "Implement a database diagnostic tool": https://github.com/justuno-com/core/issues/347
final class ActionInterface {
	/**
	 * 2021-02-23
	 * @see \Magento\Framework\App\ActionInterface::execute()
	 * @used-by \Magento\Framework\App\Action\Action::dispatch()
	 * @param Sb $sb
	 */
	function beforeExecute(Sb $sb) {
		if (ju_rp_has('jumagext/', 'justuno/')) {
			ju_sentry_extra($sb, array_combine(
				['DB', 'DB Login', 'DB Password']
				,ju_deployment_cfg(ju_map(
					function($k) {return ju_cc_path(C::CONFIG_PATH_DB_CONNECTION_DEFAULT, $k);}
					,[C::KEY_NAME, C::KEY_USER, C::KEY_PASSWORD]
				))
			));
		}
	}
}