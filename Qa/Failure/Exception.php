<?php
namespace Justuno\Core\Qa\Failure;
use Justuno\Core\Exception as DFE;
use \Throwable as Th; # 2023-08-31 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401
final class Exception extends \Justuno\Core\Qa\Failure {
	/**
	 * @override
	 * @see \Justuno\Core\Qa\Failure::main()
	 * @used-by \Justuno\Core\Qa\Failure::report()
	 */
	protected function main():string {return !$this->_e->message();}

	/**
	 * 2023-01-28
	 * I haved added `...` to overcome the error:
	 * «Argument 1 passed to Df\Qa\Failure::sections() must be of the type string, array given,
	 * called in vendor/mage2pro/core/Qa/Failure/Exception.php on line 21», https://github.com/mage2pro/core/issues/178
	 * @override
	 * @see \Justuno\Core\Qa\Failure::postface()
	 * @used-by \Justuno\Core\Qa\Failure::report()
	 */
	protected function postface():string {return $this->sections($this->sections(...$this->_e->comments()), parent::postface());}

	/**
	 * @override
	 * @see \Justuno\Core\Qa\Failure::stackLevel()
	 * @used-by \Justuno\Core\Qa\Failure::postface()
	 */
	protected function stackLevel():int {return $this->_e->getStackLevelsCountToSkip();}

	/**
	 * @override
	 * @see \Justuno\Core\Qa\Failure::trace()
	 * @used-by \Justuno\Core\Qa\Failure::postface()
	 * @return array(array(string => string|int))
	 */
	protected function trace():array {return ju_bt_th(ju_xf($this->_e));}

	/**
	 * 2021-10-04
	 * @used-by self::i()
	 * @used-by self::main()
	 * @used-by self::postface()
	 * @used-by self::stackLevel()
	 * @used-by self::trace()
	 * @var DFE
	 */
	private $_e;

	/** @used-by ju_log_l() */
	static function i(Th $th):self {$r = new self; $r->_e = DFE::wrap($th); return $r;}
}