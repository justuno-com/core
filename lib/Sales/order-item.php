<?php
use Magento\Quote\Model\Quote as Q;
use Magento\Quote\Model\Quote\Item as QI;
use Magento\Sales\Model\Order as O;
use Magento\Sales\Model\Order\Item as OI;

/**
 * 2016-09-07
 * Если товар является настраиваемым, то @uses \Magento\Sales\Model\Order::getItems()
 * будет содержать как настраиваемый товар, так и его простой вариант.
 * Настраиваемые товары мы отфильтровываем.
 *
 * 2017-01-31
 * Добавил @uses array_values(), чтобы функция возвращала именно mixed[], а не array(itemId => mixed).
 * Это важно, потому что эту функцию мы используем только для формирования запросов к API платёжных систем,
 * а этим системам порой (например, Klarna) не всё равно,
 * получат они в JSON-запросе массив или хэш с целочисленными индексами.
 *
 * array_values() надо применять именно после array_filter(),
 * потому что array_filter() создаёт дыры в индексах результата.
 *
 * 2017-02-02
 * Отныне функция упорядочивает позиции заказа по имени.
 * Ведь эта функция используется только для передачи позиций заказа в платежные системы,
 * а там они отображаются покупателю и администратору, и удобно, чтобы они были упорядочены по имени.
 *
 * 2020-08-26 "Port the `df_oqi_leafs` function" https://github.com/justuno-com/core/issues/331
 *
 * @used-by \Justuno\M2\Controller\Response\Orders::execute()
 *
 * @param O|Q $oq
 * @param \Closure|null $f [optional]
 * @param string|null $locale [optional] Используется для упорядочивания элементов.
 * @return array(int => mixed)|OI[]|QI[]
 */
function ju_oqi_leafs($oq, \Closure $f = null, $locale = null) {
	$r = df_sort_names(array_values(array_filter(
		$oq->getItems(), function($i) {/** @var OI|QI $i */ return df_oqi_is_leaf($i);}
	)), $locale, function($i) {/** @var OI|QI $i */ return $i->getName();}); /** @var OI[]|QI[] $r */
	/**
	 * 2020-02-04
	 * If we got here from the `sales_order_place_after` event, then the order is not yet saved,
	 * and order items are not yet associated with the order.
	 * I associate order items with the order manually to make @see OI::getOrder() working properly.
	 */
	if (df_is_o($oq)) {
		foreach ($r as $i) {/** @var OI $i */
			if (!$i->getOrderId()) {
				$i->setOrder($oq);
			}
		}
	}
	return !$f ? $r : array_map($f, $r);
}