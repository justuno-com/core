<?php
namespace Justuno\Core\Framework\Plugin\Data\Form\Element;
use Justuno\Core\Framework\Form\ElementI;
use Magento\Framework\Data\Form\Element\AbstractElement as Sb;
# 2015-12-13
# 2020-08-22
# "Port the `Df\Framework\Plugin\Data\Form\Element\AbstractElement` plugin" https://github.com/justuno-com/core/issues/237
class AbstractElement extends Sb {
	/**
	 * 2016-01-01
	 * The empty constructor allows us to skip the parent's one.
	 * Magento (at least on 2016-01-01) is unable to properly inject arguments into a plugin's constructor,
	 * and it leads to the error like: «Missing required argument $amount of Magento\Framework\Pricing\Amount\Base».
	 */
	function __construct() {}

	/**
	 * 2015-11-24
	 * Many operations on the element require the form's existance, so we do them in
	 * @see \Justuno\Core\Framework\Form\ElementI::onFormInitialized()
	 *
	 * 2016-03-08
	 * «@see \Magento\Framework\Data\Form\Element\AbstractElement::setForm() is called 3 times for the same element and form.»
	 * https://mage2.pro/t/901
	 * That is why we use $sb->{__METHOD__}.
	 *
	 * @see \Magento\Framework\Data\Form\Element\AbstractElement::setForm()
	 * @param Sb $sb
	 * @param Sb $r
	 * @return Sb
	 */
	function afterSetForm(Sb $sb, Sb $r) {
		if (!isset($sb->{__METHOD__}) && $sb instanceof ElementI) {
			$sb->onFormInitialized();
			$sb->{__METHOD__} = true;
		}
		return $r;
	}
}