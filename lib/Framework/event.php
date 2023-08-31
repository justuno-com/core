<?php
use Magento\Framework\Event\Manager;
use Magento\Framework\Event\ManagerInterface as IManager;
/**
 * 2015-08-16
 * https://mage2.ru/t/95
 * https://mage2.pro/t/60
 * 2020-08-24 "Port the `df_dispatch` function" https://github.com/justuno-com/core/issues/316
 * @used-by \Justuno\Core\Framework\Log\Dispatcher::handle()
 * @used-by \Justuno\M2\Controller\Cart\Add::execute()
 * @param array(string => mixed) $d
 */
function ju_dispatch(string $ev, array $d = []):void {
	$m = ju_o(IManager::class); /** @var IManager|Manager $m */
	$m->dispatch($ev, $d);
}