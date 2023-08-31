<?php
namespace Justuno\Core\Framework\Log;
use Justuno\Core\O;
use Exception as E;
# 2021-09-08
final class Record {
	/**
	 * 2021-09-08
	 * @used-by \Justuno\Core\Framework\Log\Dispatcher::handle()
	 * @param array(string => mixed) $d
	 */
	function __construct(array $d) {$this->_d = new O($d);}

	/**
	 * 2021-09-08
	 * @used-by self::ef()
	 * @used-by \Justuno\Core\Framework\Log\Dispatcher::handle()
	 * @used-by \Justuno\Core\Framework\Log\Handler\NoSuchEntity::_p()
	 * @param string|null $e [optional]
	 * @return E|null|bool
	 */
	function e($e = null) {
		$r = $this->d('context/exception'); /** @var E|null $r */
		return !$r || !$e ? $r : $r instanceof $e;
	}

	/**
	 * 2023-08-01
	 * @used-by \Justuno\Core\Framework\Log\Dispatcher::handle()
	 * @return E|null
	 */
	function ef() {return !($e = $this->e()) ? null : ju_xf($e);}

	/**
	 * 2023-08-01
	 * @used-by \Justuno\Core\Framework\Log\Dispatcher::handle()
	 */
	function extra():array {return $this->d('extra');}

	/**
	 * 2023-08-01
	 * @used-by \Justuno\Core\Framework\Log\Dispatcher::handle()
	 * @used-by \Justuno\Core\Framework\Log\Handler\BrokenReference::_p()
	 */
	function level():int {return $this->d('level');}

	/**
	 * 2021-09-08
	 * @used-by \Justuno\Core\Framework\Log\Handler\BrokenReference::_p()
	 * @used-by \Justuno\Core\Framework\Log\Handler\Cookie::_p()
	 * @used-by \Justuno\Core\Framework\Log\Handler\JsMap::_p()
	 * @used-by \Justuno\Core\Framework\Log\Handler\PayPal::_p()
	 * @param string|string[]|null $s [optional]
	 * @return string|bool
	 */
	function msg($s = '') {
		$r = $this->d('message'); /** @var string $r */
		return ju_nes($s) ? $r : ju_starts_with($r, $s);
	}

	/**
	 * 2021-09-08
	 * @used-by self::e()
	 * @used-by self::extra()
	 * @used-by self::level()
	 * @used-by self::msg()
	 * @return string|null
	 */
	private function d(string $k) {return $this->_d->a($k);}

	/**
	 * 2021-09-08
	 * @used-by self::__construct()
	 * @used-by self::d()
	 * @var O
	 */
	private $_d;
}