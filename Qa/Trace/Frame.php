<?php
namespace Justuno\Core\Qa\Trace;
use ReflectionFunction as RF;
use ReflectionFunctionAbstract as RFA;
use ReflectionMethod as RM;
use ReflectionParameter as RP;
# 2020-08-19 "Port the `Df\Qa\Trace\Frame` class" https://github.com/justuno-com/core/issues/197
final class Frame extends \Justuno\Core\O {
	/**
	 * 2015-04-03 Путь к файлу отсутствует при вызовах типа @see call_user_func()
	 * @used-by self::context()
	 * @used-by \Justuno\Core\Qa\Trace\Formatter::frame()
	 * @return string|null
	 */
	function filePath() {return $this['file'];}

	/**
	 * 2015-04-03 Строка отсутствует при вызовах типа @see call_user_func()
	 * @used-by self::context()
	 * @used-by \Justuno\Core\Qa\Trace\Formatter::frame()
	 * @return int|null
	 */
	function line() {return $this['line'];}

	/**
	 * 2015-04-03 Для простых функций (не методов) вернёт название функции.
	 * 2020-02-20
	 * $f could be `include`, `include_once`, `require`, ``require_once``:
	 * https://www.php.net/manual/function.include.php
	 * https://www.php.net/manual/function.include-once.php
	 * https://www.php.net/manual/function.require.php
	 * https://www.php.net/manual/function.require-once.php
	 * https://www.php.net/manual/function.debug-backtrace.php#111255
	 * They are not functions and will lead to a @see \ReflectionException:
	 * «Function include() does not exist»: https://github.com/tradefurniturecompany/site/issues/60
	 * https://www.php.net/manual/reflectionfunction.construct.php
	 * https://www.php.net/manual/class.reflectionexception.php
	 * @see functionA()
	 * @used-by self::functionA()
	 * @used-by self::methodParameter()
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorParam()
	 * @return RM|null
	 */
	function method() {return juc($this, function() {return
		($c = $this->className()) && ($f = $this->functionName()) && !$this->isClosure()
			? ju_try(function() use($c, $f) {return new RM($c, $f);}, null)
			: null
	;});}

	/**
	 * 2015-04-03 Для простых функций (не методов) вернёт название функции.
	 * @used-by self::__toString()
	 * @used-by self::methodParameter()
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorParam()
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorResult()
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorVariable()
	 * @return string
	 */
	function methodName() {return ju_cc_method($this->className(), $this->functionName());}

	/**
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorParam()
	 * @param int $ordering  		zero-based
	 * @return RP
	 */
	function methodParameter($ordering) {return juc($this, function($ordering) {/** @var RP $r */
		ju_assert($m = $this->method()); /** @var RM|null $m */
		if ($ordering >= count($m->getParameters())) { # Параметр должен существовать
			ju_error(
				"Программист ошибочно пытается получить значение параметра с индексом {$ordering}"
				." метода «{$this->methodName()}», хотя этот метод принимает всего %d параметров."
				,count($m->getParameters())
			);
		}
		ju_assert_lt(count($m->getParameters()), $ordering);
		ju_assert(($r = jua($m->getParameters(), $ordering)) instanceof RP);
		return $r;
	}, [$ordering]);}

	/**
	 * @used-by self::method()
	 * @used-by self::methodName()
	 * @return string
	 */
	private function className() {return ju_nts($this['class']);}

	/**
	 * 2016-07-31 Без проверки на closure будет сбой: «Function Df\Config\{closure}() does not exist».
	 * 2020-02-20
	 * $f could be `include`, `include_once`, `require`, ``require_once``:
	 * https://www.php.net/manual/function.include.php
	 * https://www.php.net/manual/function.include-once.php
	 * https://www.php.net/manual/function.require.php
	 * https://www.php.net/manual/function.require-once.php
	 * https://www.php.net/manual/function.debug-backtrace.php#111255
	 * They are not functions and will lead to a @see \ReflectionException:
	 * «Function include() does not exist»: https://github.com/tradefurniturecompany/site/issues/60
	 * https://www.php.net/manual/reflectionfunction.construct.php
	 * https://www.php.net/manual/class.reflectionexception.php
	 * @see self::method()
	 * @used-by self::context()
	 * @return RFA|RF|RM|null
	 */
	private function functionA() {return juc($this, function() {return $this->method() ?: (
		(!($f = $this->functionName())) || $this->isClosure() ? null : ju_try(function() use($f) {return new RF($f);}, null)
	);});}
	
	/**
	 * @used-by self::method()
	 * @used-by self::methodName()
	 * @return string
	 */
	private function functionName() {return ju_nts($this['function']);}

	/**
	 * 2016-07-31
	 * @used-by self::functionA()
	 * @used-by self::method()
	 * @return bool
	 */
	private function isClosure() {return ju_ends_with($this->functionName(), '{closure}');}

	/**
	 * @used-by self::context()
	 * @used-by self::i()
	 * @var self|null
	 */
	private $_next;

	/**
	 * @used-by \Justuno\Core\Qa\Method::caller()
	 * @used-by \Justuno\Core\Qa\Trace::__construct()
	 * @param array(string => string|int) $a
	 */
	static function i(array $a):self {return new self($a);}
}