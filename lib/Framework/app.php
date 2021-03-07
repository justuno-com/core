<?php
use Magento\Framework\App\DeploymentConfig as DC;
/**
 * 2021-02-24
 * @used-by \Justuno\M2\Config\Backend\Debug::dfSaveBefore()
 * @param string|string[]|null $k [optional]
 * @return DC|string|string[]|null
 */
function ju_deployment_cfg($k = null) {
	$r = ju_o(DC::class); /** @var DC $r */
	return is_null($k) ? $r : jua($r->get(), $k);
}
