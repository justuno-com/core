<?php
namespace Justuno\Core\Framework\Log\Handler;
# 2023-08-25 "Prevent logging of «Requested path <…>.js.map is wrong»": https://github.com/mage2pro/core/issues/323
final class JsMap extends \Justuno\Core\Framework\Log\Handler {
	/**
	 * 2023-08-25
	 * @override
	 * @see \Justuno\Core\Framework\Log\Handler::_p()
	 * @used-by \Justuno\Core\Framework\Log\Handler::p()
	 */
	protected function _p():bool {return self::is($this->r()->msg());}

	/**
	 * 2023-08-25
	 * @used-by self::_p()
	 * @used-by \Justuno\Core\Framework\Plugin\AppInterface::beforeCatchException()
	 */
	static function is(string $s):bool {return
		ju_starts_with($s, 'Requested path ') && ju_ends_with($s, '.js.map is wrong.')
	;}
}