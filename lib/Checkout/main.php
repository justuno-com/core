<?php
use Df\Checkout\Model\Session as DfSession;
use Justuno\Core\Exception as DFE;
use Magento\Checkout\Model\Session;
use Magento\Sales\Model\Order as O;
/**
 * 2018-10-06
 * 2020-08-24 "Port the `df_order_last` function" https://github.com/justuno-com/core/issues/311
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @param bool $required [optional]
 * @return O|null
 * @throws DFE
 */
function ju_order_last($required = true) {
	$s = df_checkout_session(); /** @var Session|DfSession $s */
	return $s->getLastRealOrderId() ? $s->getLastRealOrder() : (!$required ? null : ju_error());
}