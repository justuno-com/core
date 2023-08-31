<?php
namespace Justuno\Core\Framework\Log;
/**
 * 2021-09-08
 * @see \Justuno\Core\Framework\Log\Handler\BrokenReference
 * @see \Justuno\Core\Framework\Log\Handler\Cookie
 * @see \Justuno\Core\Framework\Log\Handler\JsMap
 * @see \Justuno\Core\Framework\Log\Handler\NoSuchEntity
 * @see \Justuno\Core\Framework\Log\Handler\PayPal
 */
abstract class Handler {
	/**
	 * 2021-09-08
	 * @used-by self::p()
	 * @see \Justuno\Core\Framework\Log\Handler\BrokenReference::_p()
	 * @see \Justuno\Core\Framework\Log\Handler\Cookie::_p()
	 * @see \Justuno\Core\Framework\Log\Handler\JsMap::_p()
	 * @see \Justuno\Core\Framework\Log\Handler\NoSuchEntity::_p()
	 * @see \Justuno\Core\Framework\Log\Handler\PayPal::_p()
	 */
	abstract protected function _p():bool;

	/**
	 * 2021-08-09
	 * @used-by \Justuno\Core\Framework\Log\Handler\BrokenReference::_p()
	 * @used-by \Justuno\Core\Framework\Log\Handler\Cookie::_p()
	 * @used-by \Justuno\Core\Framework\Log\Handler\JsMap::_p()
	 * @used-by \Justuno\Core\Framework\Log\Handler\NoSuchEntity::_p()
	 * @used-by \Justuno\Core\Framework\Log\Handler\PayPal::_p()
	 */
	final protected function r():Record {return $this->_r;}

	/**
	 * 2021-09-08
	 * @used-by self::p()
	 */
	private function __construct(Record $r) {$this->_r = $r;}

	/**
	 * 2021-09-08
	 * @used-by self::__construct()
	 * @used-by self::r()
	 * @var Record
	 */
	private $_r;

	/**
	 * 2021-09-08
	 * @used-by \Justuno\Core\Framework\Log\Dispatcher::handle()
	 */
	final static function p(Record $r):bool {
		$i = new static($r); /** @var self $i */
		return $i->_p();
	}
}