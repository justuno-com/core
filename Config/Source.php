<?php
namespace Justuno\Core\Config;
/**
 * 2015-11-14 Descendants of this class are not singletons because of  @see \Df\Config\Plugin\Model\Config\SourceFactory
 * 2017-03-28
 * This class should be a descendant of @see \Magento\Framework\DataObject to retrieve the `path` property value:
 * @see \Justuno\Core\Config\Source::setPath()
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
	 * @used-by toOptionArray()
	 * @return array(<value> => <label>)
	 */
	abstract protected function map();

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
	 * 2017-03-28
	 * @used-by pathA()
	 * @used-by setPath()
	 * @var string
	 */
	private $_path;
}