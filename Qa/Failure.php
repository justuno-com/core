<?php
namespace Justuno\Core\Qa;
use Justuno\Core\Qa\Trace\Formatter;
/**
 * @see \Justuno\Core\Qa\Failure\Exception
 */
abstract class Failure {
	/**
	 * @used-by self::report()
	 * @see \Justuno\Core\Qa\Failure\Exception::main()
	 */
	abstract protected function main():string;

	/**
	 * @abstract
	 * @used-by self::postface()
	 * @see \Justuno\Core\Qa\Failure\Exception::trace()
	 * @return array(array(string => string|int))
	 */
	abstract protected function trace():array;

	/** @used-by ju_log_l() */
	final function report():string {return juc($this, function() {return $this->sections(
		$this->preface(), $this->main(), $this->postface()
	);});}

	/**
	 * @used-by self::report()
	 * @used-by \Justuno\Core\Qa\Failure\Exception::postface()
	 * @see \Justuno\Core\Qa\Failure\Exception::postface()
	 */
	protected function postface():string {return Formatter::p(new Trace(array_slice($this->trace(), $this->stackLevel())));}

	/** @used-by self::report() */
	protected function preface():string {return '';}

	/**
	 * @used-by self::report()
	 * @used-by \Justuno\Core\Qa\Failure\Exception::postface()
	 */
	protected function sections(string ...$a):string {
		static $s; $s = $s ? $s : "\n" . str_repeat('*', 36) . "\n"; /** @var string $s */
		return implode($s, array_filter(ju_trim($a)));
	}

	/**
	 * @used-by self::postface()
	 * @see \Justuno\Core\Qa\Failure\Exception::stackLevel()
	 */
	protected function stackLevel():int {return 0;}
}