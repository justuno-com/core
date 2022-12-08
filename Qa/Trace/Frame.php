<?php
namespace Justuno\Core\Qa\Trace;
use ReflectionMethod as RM;
use ReflectionParameter as RP;
final class Frame extends \Justuno\Core\O {
	/**
	 * 2015-04-03 Путь к файлу отсутствует при вызовах типа @see call_user_func()
	 * @used-by \Justuno\Core\Qa\Trace\Formatter::frame()
	 * @return string|null
	 */
	function filePath() {return $this['file'];}

	/**
	 * 2015-04-03 Строка отсутствует при вызовах типа @see call_user_func()
	 * @used-by \Justuno\Core\Qa\Trace\Formatter::frame()
	 * @return int|null
	 */
	function line() {return $this['line'];}

	/**
	 * 2015-04-03 Для простых функций (не методов) вернёт название функции.
	 * @used-by self::methodParameter()
	 * @used-by Formatter::frame()
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorParam()
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorResult()
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorVariable()
	 */
	function method():string {return ju_cc_method($this->class_(), $this->function_());}

	/**
	 * 2020-02-20
	 * $f could be `include`, `include_once`, `require`, `require_once`:
	 * https://www.php.net/manual/function.include.php
	 * https://www.php.net/manual/function.include-once.php
	 * https://www.php.net/manual/function.require.php
	 * https://www.php.net/manual/function.require-once.php
	 * https://www.php.net/manual/function.debug-backtrace.php#111255
	 * They are not functions and will lead to a @see \ReflectionException:
	 * «Function include() does not exist»: https://github.com/tradefurniturecompany/site/issues/60
	 * https://www.php.net/manual/reflectionfunction.construct.php
	 * https://www.php.net/manual/class.reflectionexception.php
	 * @used-by self::methodParameter()
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorParam()
	 * @return RM|null
	 */
	function methodR() {return juc($this, function() {return
		($c = $this->class_()) && ($f = $this->function_()) && !$this->isClosure()
			? ju_try(function() use($c, $f) {return new RM($c, $f);}, null)
			: null
	;});}

	/**
	 * $ordering is zero-based
	 * @used-by \Justuno\Core\Qa\Method::raiseErrorParam()
	 */
	function methodParameter(int $ordering):RP {return juc($this, function($ordering) {/** @var RP $r */
		ju_assert($m = $this->methodR()); /** @var RM|null $m */
		if ($ordering >= count($m->getParameters())) { # Параметр должен существовать
			ju_error(
				"Программист ошибочно пытается получить значение параметра с индексом {$ordering}"
				." метода «{$this->method()}», хотя этот метод принимает всего %d параметров."
				,count($m->getParameters())
			);
		}
		ju_assert_lt(count($m->getParameters()), $ordering);
		ju_assert(($r = jua($m->getParameters(), $ordering)) instanceof RP);
		return $r;
	}, [$ordering]);}

	/**
	 * @used-by self::methodR()
	 * @used-by self::method()
	 */
	private function class_():string {return ju_nts($this['class']);}

	/**
	 * @used-by self::methodR()
	 * @used-by self::method()
	 */
	private function function_():string {return ju_nts($this['function']);}

	/**
	 * 2016-07-31
	 * @used-by self::methodR()
	 */
	private function isClosure():bool {return ju_ends_with($this->function_(), '{closure}');}

	/**
	 * @used-by \Justuno\Core\Qa\Method::caller()
	 * @used-by \Justuno\Core\Qa\Trace::__construct()
	 * @param array(string => string|int) $a
	 */
	static function i(array $a):self {return new self($a);}
}