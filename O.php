<?php
namespace Justuno\Core;
/**
 * 2017-07-13
 * 2020-08-19 "Port the `Df\Core\O` class" https://github.com/justuno-com/core/issues/195
 * @see \Justuno\Core\Qa\Trace\Frame
 */
class O implements \ArrayAccess {
	/**
	 * 2017-07-13
	 * @used-by \Justuno\Core\Framework\Log\Record::__construct()
	 * @used-by \Justuno\Core\Qa\Failure\Exception::i()
	 * @param array(string => mixed) $a [optional]
	 */
	final function __construct(array $a = []) {$this->_a = $a;}

	/**
	 * 2017-07-13
	 * @used-by \Justuno\Core\Framework\Log\Record::d()
	 * @used-by \Justuno\Core\Qa\Failure::postface()
	 * @param string|string[]|null $k [optional]
	 * @param string|null $d [optional]
	 * @return array(string => mixed)|mixed|null
	 */
	function a($k = null, $d = null) {return jua($this->_a, $k, $d);}

	/**
	 * 2017-07-13
	 * «This method is executed when using isset() or empty() on objects implementing ArrayAccess.
	 * When using empty() ArrayAccess::offsetGet() will be called and checked if empty
	 * only if ArrayAccess::offsetExists() returns TRUE».
	 * https://php.net/manual/arrayaccess.offsetexists.php
	 * @override
	 * @see \ArrayAccess::offsetExists()
	 * @param string $k
	 */
	function offsetExists($k):bool {return !is_null(jua_deep($this->_a, $k));}

	/**
	 * 2017-07-13
	 * 2022-11-30
	 * 1) `mixed` as a return type is not supported by PHP < 8:
	 * https://github.com/mage2pro/core/issues/168#user-content-mixed
	 * 2) `ReturnTypeWillChange` allows us to suppress the return type absence notice:
	 * https://github.com/mage2pro/core/issues/168#user-content-absent-return-type-deprecation
	 * https://github.com/mage2pro/core/issues/168#user-content-returntypewillchange
	 * @override
	 * @see \ArrayAccess::offsetGet()
	 * @param string $k
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
	function offsetGet($k) {return jua_deep($this->_a, $k);}

	/**
	 * 2017-07-13
	 * @override
	 * @see \ArrayAccess::offsetSet()
	 * @param string $k
	 * @param mixed $v
	 */
	function offsetSet($k, $v):void {jua_deep_set($this->_a, $k, $v);}

	/**
	 * 2017-07-13
	 * @override
	 * @see \ArrayAccess::offsetUnset()
	 * @param string $k
	 */
	function offsetUnset($k):void {jua_deep_unset($this->_a, $k);}

	/**
	 * 2017-07-13
	 * @used-by self::__construct()
	 * @used-by self::a()
	 * @var array(string => mixed)
	 */
	private $_a;
}