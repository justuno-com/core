<?php
namespace Justuno\Core\Config;
/**
 * 2015-11-14 Descendants of this class are not singletons because of  @see \Df\Config\Plugin\Model\Config\SourceFactory
 * 2017-03-28
 * This class should be a descendant of @see \Magento\Framework\DataObject to retrieve the `path` property value:
 * @see \Df\Config\Source::setPath()
 * @see \Magento\Config\Model\Config\Structure\Element\Field::_getOptionsFromSourceModel()
 *		$sourceModel = $this->_sourceFactory->create($sourceModel);
 *		if ($sourceModel instanceof \Magento\Framework\DataObject) {
 *			$sourceModel->setPath($this->getPath());
 *		}
 * https://github.com/magento/magento2/blob/2.1.5/app/code/Magento/Config/Model/Config/Structure/Element/Field.php#L435-L438
 * 2020-08-22 "Port the `Df\Config\Source` class" https://github.com/justuno-com/core/issues/257
 * @see \Justuno\M2\Source\Brand
 */
abstract class Source extends \Df\Config\SourceBase {
	/**
	 * 2015-11-14
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @return array(<value> => <label>)
	 */
	abstract protected function map();
	/**
	 * 2016-07-05
	 * @used-by \Df\Payment\Settings\Options::denied()
	 * @used-by \KingPalm\B2B\Block\Registration::_toHtml()
	 * @see \Df\Payment\Metadata::keys()
	 * @return string[]
	 */
	function keys() {return dfc($this, function() {return array_keys($this->map());});}

	/**
	 * 2016-08-07
	 * @used-by \Df\GingerPaymentsBase\Source\Option::optionsTest()
	 * @used-by \Df\Payment\Settings\Options::o()
	 * @param string[]|null $k [optional]
	 * @return array(<value> => <label>)
	 */
	final function options($k = null) {return df_translate_a(dfa($this->map(), $k));}

	/**
	 * 2017-03-28
	 * @used-by \Magento\Config\Model\Config\Structure\Element\Field::_getOptionsFromSourceModel()
	 *		$sourceModel = $this->_sourceFactory->create($sourceModel);
	 *		if ($sourceModel instanceof \Magento\Framework\DataObject) {
	 *			$sourceModel->setPath($this->getPath());
	 *		}
	 * https://github.com/magento/magento2/blob/2.1.5/app/code/Magento/Config/Model/Config/Structure/Element/Field.php#L435-L438
	 * @param string $v
	 */
	final function setPath($v) {$this->_path = $v;}

	/**
	 * 2015-11-27
	 * @override
	 * @see \Magento\Framework\Option\ArrayInterface::toOptionArray()                             
	 * @used-by getAllOptions()
	 * @used-by \Magento\Config\Model\Config\Structure\Element\Field::_getOptionsFromSourceModel()
	 * @return array(array('label' => string, 'value' => int|string))
	 */
	final function toOptionArray() {return df_map_to_options_t($this->map());}

	/**
	 * 2015-11-14
	 * Возаращает по имени атрибут или содержимое дочернего тега для настроечного поля.
	 * Например, пусть есть поле:
	 *		<field
	 *			id='visibility'
	 *			translate='label'
	 *			type='select'
	 *			sortOrder='1'
	 *			showInDefault='1'
	 *			showInWebsite='1'
	 *			showInStore='1'
	 *		>
	 *			<label>Visibility</label>
	 *			<source_model>Dfe\Sku\ConfigSource\Visibility</source_model>
	 *			<comment><![CDATA[<a href='https://mage2.pro/t/197'>Documentation.</a>]]></comment>
	 *		</field>
	 * Тогда
	 * df_config_field()->getData() вернёт такой массив:
	 *	array(
	 *		[_elementType] => field
	 *		[comment] => <a href='https://mage2.pro/t/197'>Documentation.</a>
	 *		[id] => visibility
	 *		[label] => Visibility
	 *		[path] => dfe_sku/frontend
	 *		[showInDefault] => 1
	 *		[showInStore] => 1
	 *		[showInWebsite] => 1
	 *		[sortOrder] => 1
	 *		[source_model] => Dfe\Sku\ConfigSource\Visibility
	 *		[translate] => label
	 *		[type] => select
	 *	)
	 * Обратите внимание: массив содержит и атрибуты, и детей.
	 *
	 * @used-by \Df\Config\Source\LetterCase::map()
	 *
	 * @param string $k
	 * @return string|null
	 */
	final protected function f($k) {return df_config_field()->getAttribute($k);}

	/**
	 * 2017-04-10 «all_pay»
	 * @used-by \Df\Payment\Source::titleB()
	 * @param string $k
	 * @return string
	 */
	final protected function sibling($k) {return df_cfg(
		df_cc_path(df_head($this->pathA()), $k), df_scope()
	);}

	/**
	 * 2017-03-28
	 * @used-by sibling()
	 * @used-by \Df\Payment\Source\API\Key\Testable::_test()
	 * @used-by \Df\ZohoBI\Source\Organization::app()
	 * @return string[]
	 */
	final protected function pathA() {return dfc($this, function() {return df_explode_path(
		$this->_path
	);});}

	/**
	 * 2016-07-12
	 * @final I do not use the PHP «final» keyword here to allow refine the return type using PHPDoc.
	 * @used-by \Dfe\IPay88\ConfigProvider::options()
	 * @used-by \Dfe\IPay88\W\Event::optionTitle()
	 * @used-by \KingPalm\B2B\Block\Registration::_toHtml()
	 * @return self
	 */
	static function s() {return dfcf(function($c) {return new $c;}, [static::class]);}

	/**
	 * 2017-02-05
	 * @used-by \Dfe\Paymill\Source\Prefill\With3DS::map()
	 * @used-by \Dfe\Paymill\Source\Prefill\Without3DS::map()
	 * @used-by \Dfe\Spryng\Source\Prefill::map()
	 * @param array(string => string) $a
	 * @return array(string => string)
	 */
	final protected static function addKeysToValues(array $a) {return df_map_k(
		$a, function($k, $v) {return "$v: $k";}
	);}

	/**
	 * 2017-03-28
	 * @used-by pathA()
	 * @used-by setPath()
	 * @var string
	 */
	private $_path;
}