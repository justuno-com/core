<?php
namespace Justuno\Core\Zf;
# 2020-06-22 "Port the `Df\Zf\Validate` class": https://github.com/justuno-com/core/issues/112
/**
 * @see \Justuno\Core\Zf\Validate\ArrayT
 * @see \Justuno\Core\Zf\Validate\StringT
 * @see \Justuno\Core\Zf\Validate\StringT\IntT
 * @see \Justuno\Core\Zf\Validate\StringT\Iso2
 * @see \Justuno\Core\Zf\Validate\StringT\Parser
 * @used-by \Justuno\Core\Zf\Validate\ArrayT::s()
 * @used-by \Justuno\Core\Zf\Validate\StringT::s()
 * @used-by \Justuno\Core\Zf\Validate\StringT\IntT::s()
 * @used-by \Justuno\Core\Zf\Validate\StringT\Iso2::s()
 * @used-by \Justuno\Core\Zf\Validate\StringT\FloatT::s()
 */
abstract class Validate implements \Zend_Validate_Interface {
	/**
	 * @used-by self::message()
	 * @see \Justuno\Core\Zf\Validate\ArrayT::expected()
	 * @see \Justuno\Core\Zf\Validate\StringT::expected()
	 * @see \Justuno\Core\Zf\Validate\StringT\FloatT::expected()
	 * @see \Justuno\Core\Zf\Validate\StringT\IntT::expected()
	 * @see \Justuno\Core\Zf\Validate\StringT\Iso2::expected()
	 */
	abstract protected function expected():string;

	/**
	 * @override
	 * @see \Zend_Validate_Interface::getMessages()
	 * @return array(string => string)
	 */
	final function getMessages():array {return [__CLASS__ => $this->message()];}

	/**
	 * @used-by df_float()
	 * @used-by df_int()
	 * @used-by \Justuno\Core\Zf\Validate::getMessages()
	 */
	final function message():string {$v = $this->v(); return is_null($v)
		? "Got `NULL` instead of {$this->expected()}."
		: sprintf("Unable to recognize the value «%s» of type «%s» as {$this->expected()}.", ju_string_debug($v), gettype($v))
	;}

	/**
	 * @used-by \Justuno\Core\Zf\Validate\ArrayT::isValid()
	 * @used-by \Justuno\Core\Zf\Validate\StringT::isValid()
	 * @used-by \Justuno\Core\Zf\Validate\StringT\FloatT::isValid()
	 * @used-by \Justuno\Core\Zf\Validate\StringT\IntT::isValid()
	 * @used-by \Justuno\Core\Zf\Validate\StringT\Iso2::isValid()
	 * @used-by \Justuno\Core\Zf\Validate\StringT\Parser::isValid()
	 * @param mixed $v [optional]
	 * @return self|mixed
	 */
	final protected function v($v = JU_N) {return ju_prop($this, $v);}
}