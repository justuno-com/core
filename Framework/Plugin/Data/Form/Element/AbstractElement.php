<?php
namespace Justuno\Core\Framework\Plugin\Data\Form\Element;
use Justuno\Core\Framework\Form\ElementI;
use Magento\Framework\Data\Form\Element\AbstractElement as Sb;
# 2015-12-13
# 2020-08-22
# "Port the `Df\Framework\Plugin\Data\Form\Element\AbstractElement` plugin" https://github.com/justuno-com/core/issues/237
# 2023-08-31
# "Prevent interceptors generation for the plugins extended from interceptable classes":
# https://github.com/justuno-com/core/issues/406
class AbstractElement extends Sb implements \Magento\Framework\ObjectManager\NoninterceptableInterface {
	/**
	 * 2016-01-01
	 * The empty constructor allows us to skip the parent's one.
	 * Magento (at least on 2016-01-01) is unable to properly inject arguments into a plugin's constructor,
	 * and it leads to the error like: «Missing required argument $amount of Magento\Framework\Pricing\Amount\Base».
	 */
	function __construct() {}

	/**
	 * 2015-10-09
	 * Цель метода — отключение автозаполнения полей.
	 * https://developers.google.com/web/fundamentals/input/form/label-and-name-inputs?hl=en#recommended-input-name-and-autocomplete-attribute-values
	 * @see \Magento\Framework\Data\Form\Element\AbstractElement::getHtmlAttributes()
	 * @param string[] $r
	 * @return string[]
	 */
	function afterGetHtmlAttributes(Sb $sb, array $r):array {return array_merge($r, ['autocomplete']);}

	/**
	 * 2016-03-08
	 * 1) Many built-in classes do not call getBeforeElementHtml():
	 * *) @see \Magento\Framework\Data\Form\Element\Textarea::getElementHtml()
	 * https://mage2.pro/t/150
	 * *) @see \Magento\Framework\Data\Form\Element\Fieldset::getElementHtml()
	 * https://mage2.pro/t/248
	 * *) @see \Magento\Framework\Data\Form\Element\Multiselect::getElementHtml()
	 * https://mage2.pro/t/902
	 * I need getBeforeElementHtml() for @see ju_fe_init()
	 * 2) @see \Magento\Framework\Data\Form\Element\AbstractElement::getElementHtml()
	 * places before_element_html into a <label>:
	 * https://github.com/magento/magento2/blob/487f5f45/lib/internal/Magento/Framework/Data/Form/Element/AbstractElement.php#L350-L353
	 * @see \Magento\Framework\Data\Form\Element\AbstractElement::getElementHtml()
	 * @param Sb $sb
	 */
	function afterGetElementHtml(Sb $sb, string $r):string {return
		ju_starts_with($r, '<label class="addbefore"') ? $r : ju_prepend($r, (string)$sb->getBeforeElementHtml())
	;}

	/**
	 * 2015-11-24
	 * Many operations on the element require the form's existance, so we do them in
	 * @see \Justuno\Core\Framework\Form\ElementI::onFormInitialized()
	 * 2016-03-08
	 * «@see \Magento\Framework\Data\Form\Element\AbstractElement::setForm() is called 3 times for the same element and form.»
	 * https://mage2.pro/t/901
	 * That is why we use @uses juc()
	 * @see \Magento\Framework\Data\Form\Element\AbstractElement::setForm()
	 */
	function afterSetForm(Sb $sb, Sb $r):Sb {
		if ($sb instanceof ElementI) {
			juc($sb, function() use($sb) {$sb->onFormInitialized();});
		}
		return $r;
	}
}