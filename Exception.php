<?php
namespace Justuno\Core;
use \Exception as E;
use Magento\Framework\Exception\LocalizedException as LE;
use Magento\Framework\Phrase;
/**
 * 2020-06-15 "Port the `Df\Core\Exception` class": https://github.com/justuno-com/core/issues/23
 * @used-by ju_param_sne()
 */
final class Exception extends LE implements \ArrayAccess {
	/**
	 * @used-by ju_error_create()
	 * @param mixed ...$args
	 */
	function __construct(...$args) {
		$arg0 = jua($args, 0); /** @var string|Phrase|E|array(string => mixed)|null $arg0 */
		$prev = null; /** @var E|LE|null $prev */
		$m = null;  /** @var Phrase|null $m */
		# 2015-10-10
		if (is_array($arg0)) {
			$this->_data = $arg0;
		}
		elseif ($arg0 instanceof Phrase) {
			$m = $arg0;
		}
		elseif (is_string($arg0)) {
			$m = __($arg0);
		}
		elseif ($arg0 instanceof E) {
			$prev = $arg0;
		}
		$arg1 = jua($args, 1); /** @var int|string|E|Phrase|null $arg1 */
		if (!is_null($arg1)) {
			if ($arg1 instanceof E) {
				$prev = $arg1;
			}
			elseif (is_int($prev)) {
				$this->_stackLevelsCountToSkip = $arg1;
			}
			elseif (is_string($arg1) || $arg1 instanceof Phrase) {
				$this->comment((string)$arg1);
			}
		}
		if (is_null($m)) {
			$m = __($prev ? ju_ets($prev) : 'No message');
			# 2017-02-20 To facilite the «No message» diagnostics.
			if (!$prev) {
				ju_bt();
			}
		}
		parent::__construct($m, $prev);
	}

	/**
	 * @used-by self::__construct()
	 * @param mixed ...$args
	 */
	function comment(...$args):void {$this->_comments[]= ju_format($args);}

	/**
	 * @used-by \Justuno\Core\Qa\Message_Failure_Exception::preface()
	 * @return string[]
	 */
	function comments():array {return $this->_comments;}

	/**
	 * @used-by \Justuno\Core\Qa\Message_Failure_Exception::stackLevel()
	 */
	function getStackLevelsCountToSkip():int {return $this->_stackLevelsCountToSkip;}

	/**
	 * @used-by ju_ets()
	 * @used-by \Justuno\Core\Qa\Message\Failure\Exception::main()
	 * @used-by \Justuno\Core\Sentry\Client::captureException()
	 */
	function message():string {return $this->getMessage();}

	/**
	 * 2015-10-10
	 * @override
	 * @see \ArrayAccess::offsetExists()
	 * @param string $offset
	 */
	function offsetExists($offset):bool {return isset($this->_data[$offset]);}

	/**
	 * 2015-10-10
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
	function offsetGet($k) {return jua($this->_data, $k);}

	/**
	 * 2015-10-10
	 * @override
	 * @see \ArrayAccess::offsetSet()
	 * @param string $offset
	 * @param mixed $value
	 */
	function offsetSet($offset, $value):void {$this->_data[$offset] = $value;}

	/**
	 * 2015-10-10
	 * @override
	 * @see \ArrayAccess::offsetUnset()
	 * @param string $offset
	 */
	function offsetUnset($offset):void {unset($this->_data[$offset]);}

	/**
	 * 2016-10-24
	 * @used-by \Justuno\Core\Qa\Message\Failure\Exception::reportNamePrefix()
	 * @return string|string[]
	 */
	final function reportNamePrefix() {return [ju_module_name_lc($this->module()), 'exception'];}

	/**
	 * 2017-01-09
	 * @used-by ju_sentry()
	 * @return array(string => mixed)
	 */
	function sentryContext() {return [];}

	/**
	 * 2017-10-03
	 * @used-by \Justuno\Core\Sentry\Client::captureException()
	 * @return string
	 */
	function sentryType() {return get_class($this);}

	/**
	 * 2017-10-03
	 * The allowed results:
	 * 1) A module name. E.g.: «A_B».
	 * 2) A class name. E.g.: «A\B\C».
	 * 3) An object. It will be treated as case 2 after @see get_class()
	 * @used-by reportNamePrefix()
	 * @return string|object
	 */
	protected function module() {return $this;}

	/**
	 * @used-by self::comment()
	 * @used-by self::comments()
	 * @var string[]
	 */
	private $_comments = [];

	/**
	 * 2015-10-10
	 * @var array(string => mixed)
	 */
	private $_data = [];

	/**
	 * Количество последних элементов стека вызовов,
	 * которые надо пропустить как несущественные
	 * при показе стека вызовов в диагностическом отчёте.
	 * Это значение становится положительным,
	 * когда исключительная ситуация возбуждается не в момент её возникновения,
	 * а в некоей вспомогательной функции-обработчике, вызываемой в сбойном участке:
	 * @see \Justuno\Core\Qa\Method::throwException()
	 * @var int
	 */
	private $_stackLevelsCountToSkip = 0;

	/**
	 * @used-by ju_ewrap()
	 */
	static function wrap(E $e):self {return $e instanceof self ? $e : new self($e);}
}