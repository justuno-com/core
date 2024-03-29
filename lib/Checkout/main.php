<?php
use Justuno\Core\Checkout\Model\Session as JuSession;
use Justuno\Core\Exception as DFE;
use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Sales\Model\Order as O;
/**
 * 2019-04-17
 * 2020-08-24 "Port the `df_cart` function" https://github.com/justuno-com/core/issues/315
 * @used-by \Justuno\M2\Controller\Cart\Add::execute()
 */
function ju_cart():Cart {return ju_o(Cart::class);}

/**
 * 2016-05-06
 * 2020-08-24 "Port the `df_checkout_session` function" https://github.com/justuno-com/core/issues/312
 * @used-by ju_order_last()
 * @return Session|JuSession
 */
function ju_checkout_session() {return ju_o(Session::class);}

/**
 * 2018-10-06
 * 2020-08-24 "Port the `df_order_last` function" https://github.com/justuno-com/core/issues/311
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @return O|null
 * @throws DFE
 */
function ju_order_last(bool $req = true) {
	$s = ju_checkout_session(); /** @var Session|JuSession $s */
	return $s->getLastRealOrderId() ? $s->getLastRealOrder() : (!$req ? null : ju_error());
}