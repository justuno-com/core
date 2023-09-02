<?php
use Magento\Framework\Data\Form\Element\AbstractElement as AE;
/**
 * 2015-11-28
 * 2020-08-22 "Port the `df_fe_init` function" https://github.com/justuno-com/core/issues/242
 * @used-by \Justuno\M2\Block\GenerateToken::onFormInitialized()
 * @param string|object|null $class [optional]
 * $class could be:
 * 1) A class name: «A\B\C».
 * 2) An object. It is reduced to case 1 via @see get_class()
 * @param string|string[] $css [optional]
 * @param array(string => string) $params [optional]
 * @param string|null $path [optional]
 */
function ju_fe_init(AE $e, $class = null, $css = [], array $params = [], $path = null):void {
	$class = ju_cts($class ?: $e);
	$moduleName = ju_module_name($class); /** @var string $moduleName */
	# 2015-12-29
	# Мы различаем ситуации, когда $path равно null и пустой строке.
	# *) null означает, что имя ресурса должно определяться по имени класса.
	# *) пустая строка означает, что ресурс не имеет префикса, т.е. его имя просто «main».
	if (is_null($path)) {
		$classA = ju_explode_class_lc($class); /** @var string[] $classA */
		$classLast = array_pop($classA);
		switch ($classLast) {
			# Если имя класса заканчивается на FormElement,
			# то это окончание в пути к ресурсу отбрасываем.
			case 'formElement':
			case 'fE': # 2018-04-19
				break; # $path будет равно null
			# Если имя класса заканчивается на Element,
			# то в качестве пути к ресурсу используем предыдущую часть класса.
			# Пример: «Dfe\SalesSequence\Config\Matrix\Element» => «matrix»
			case 'element':
				$path = array_pop($classA);
				break;
			default:
				$path = $classLast;
		}
	}
	# 2015-12-29
	# Используем df_ccc, чтобы отбросить $path, равный пустой строке.
	# Если имя класса заканчивается на FormElement, то это окончание в пути к ресурсу отбрасываем.
	$path = ju_ccc('/', 'formElement', $path, 'main');
	/**
	 * 2015-12-29
	 * На практике заметил, что основной файл CSS используется почти всегда,
	 * и его имя имеет формат: Df_Framework::formElement/color/main.css.
	 * Добавляем его обязательно в конец массива,
	 * чтобы правила основного файла CSS элемента
	 * имели приоритет над правилами библиотечных файлов CSS,
	 * которые элемент мог включать в массив $css.
	 * Обратите внимание, что мы даже не проверяем,
	 * присутствует ли уже $mainCss в массиве $css,
	 * потому что @uses df_link_inline делает это сама.
	 */
	$css = ju_array($css);
	/**
	 * 2015-12-30
	 * Раньше я думал, что основной файл CSS используется всегда, однако нашлось исключение:
	 * @see \Dfe\CurrencyFormat\FE обходится в настоящее время без CSS.
	 */
	if (ju_asset_exists($path, $moduleName, 'less')) {
		$css[]= ju_asset_name($path, $moduleName, 'css');
	}
	/**
	 * 2016-03-08
	 * Отныне getBeforeElementHtml() будет гарантированно вызываться благодаря
	 * @used-by \Justuno\Core\Framework\Plugin\Data\Form\Element\AbstractElement::afterGetElementHtml()
	 * 2017-08-10
	 * I have removed @see df_clean() for $params.
	 * The previous edition: https://github.com/mage2pro/core/blob/2.10.11/Framework/lib/form.php#L177
	 */
	$e['before_element_html'] .= ju_cc_n(
		!ju_asset_exists($path, $moduleName, 'js') ? null : ju_js($moduleName, $path, ['id' => $e->getHtmlId()] + $params)
		,ju_link_inline($css)
	);
}