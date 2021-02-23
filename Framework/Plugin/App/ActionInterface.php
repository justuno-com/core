<?php
namespace Justuno\Core\Framework\Plugin\App;
use Magento\Framework\App\ActionInterface as Sb;
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
			ju_sentry_extra($sb, [
				'DB' => 'test'
				,'DB Login' => 'login'
				,'DB Password' => 'password'
			]);
		}
	}
}