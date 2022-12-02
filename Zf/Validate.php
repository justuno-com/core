<?php
namespace Justuno\Core\Zf;
# 2020-06-22 "Port the `Df\Zf\Validate` class": https://github.com/justuno-com/core/issues/112
/**
 * @see \Justuno\Core\Zf\Validate\StringT
 * @see \Justuno\Core\Zf\Validate\StringT\IntT
 * @used-by \Justuno\Core\Zf\Validate\StringT::s()
 * @used-by \Justuno\Core\Zf\Validate\StringT\IntT::s()
 */
abstract class Validate implements \Zend_Validate_Interface {
	/**
	 * @used-by self::message()
	 * @see \Justuno\Core\Zf\Validate\StringT::expected()
	 * @see \Justuno\Core\Zf\Validate\StringT\IntT::expected()
	 */
	abstract protected function expected():string;

	/**
	 * @override
	 * @see \Zend_Validate_Interface::getMessages()
	 * @return array(string => string)
	 */
	final function getMessages():array {return [__CLASS__ => $this->message()];}

	/**
	 * @used-by ju_int()
	 * @used-by \Justuno\Core\Zf\Validate::getMessages()
	 */
	final function message():string {$v = $this->v(); return is_null($v)
		? "Got `NULL` instead of {$this->expected()}."
		: sprintf("Unable to recognize the value «%s» of type «%s» as {$this->expected()}.", ju_string_debug($v), gettype($v))
	;}

	/**
	 * @used-by \Justuno\Core\Zf\Validate\StringT::isValid()
	 * @used-by \Justuno\Core\Zf\Validate\StringT\IntT::isValid()
	 * @param mixed $v [optional]
	 * @return self|mixed
	 */
	final protected function v($v = JU_N) {return ju_prop($this, $v);}
}