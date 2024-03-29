<?php
namespace Justuno\Core\Framework\W\Result;
/**
 * 2016-08-24                                                                               
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * 2020-08-23 "Port the `Df\Framework\W\Result\Json` class" https://github.com/justuno-com/core/issues/270
 * @used-by \Justuno\M2\Controller\Cart\Add()
 */
class Json extends Text {
	/**
	 * 2016-08-24
	 * 2016-03-18
	 * «The @see \Magento\Framework\App\Response\Http::representJson()
	 * does not specifies a JSON response's charset and removes a previously specified charset,
	 * so not-latin characters are rendered incorrectly by all the modern browsers»
	 * https://mage2.pro/t/976
	 * @override
	 * @see \Justuno\Core\Framework\W\Result\Text::contentType()
	 * @used-by \Justuno\Core\Framework\W\Result\Text::render()
	 */
	final protected function contentType():string {return 'application/json';}

	/**
	 * 2016-08-24
	 * @override
	 * @see \Justuno\Core\Framework\W\Result\Text::prepare()
	 * @used-by \Justuno\Core\Framework\W\Result\Text::i()
	 * @param string|object|mixed[] $b
	 */
	final protected function prepare($b):string {return !is_array($b) && !is_object($b) ? $b : ju_json_encode($b);}
}