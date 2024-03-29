<?php
namespace Justuno\Core\Qa;
use Justuno\Core\Qa\Trace\Frame;
use Zend_Validate_Interface as Vd;
use \Exception as E;
use \ReflectionParameter as RP;
# 2020-06-20 "Port the `Df\Qa\Method` class": https://github.com/justuno-com/core/issues/95
final class Method {
	/**
	 * @used-by ju_param_sne()
	 * @throws E
	 */
	static function raiseErrorParam(string $method, array $messages, int $ord, int $sl = 1):void {
		$frame = self::caller($sl); /** @var Frame $frame */
		$name = 'unknown'; /** @var string $name */
		if ($frame->method()) {/** @var RP $param */
			$name = $frame->methodParameter($ord)->getName();
		}
		$messagesS = ju_cc_n($messages); /** @var string $messagesS */
		self::throwException(
			"[{$frame->method()}]"
			."\nThe argument «{$name}» is rejected by the «{$method}» validator."
			."\nThe diagnostic message:\n{$messagesS}\n\n"
			,$sl
		);
	}

	/**
	 * @used-by ju_result_s()
	 * @used-by ju_result_sne()
	 * @used-by vr()
	 * @throws E
	 */
	static function raiseErrorResult(string $vd, array $messages, int $sl = 1):void {
		$messagesS = ju_cc_n($messages); /** @var string $messagesS */
		$method = self::caller($sl)->method(); /** @var string $method */
		self::throwException(
			"[{$method}]\nA result of this method is rejected by the «{$vd}» validator."
			."\nThe diagnostic message:\n{$messagesS}\n\n"
			, $sl
		);
	}

	/**
	 * @used-by ju_assert_sne()
	 * @used-by vv()
	 * @throws E
	 */
	static function raiseErrorVariable(string $vd, array $messages, int $sl = 1) {
		$messagesS = ju_cc_n($messages); /** @var string $messagesS */
		$method = self::caller($sl)->method(); /** @var string $method */
		self::throwException(
			"[{$method}]\nThe validator «{$vd}» has catched a variable with an invalid value."
			."\nThe diagnostic message:\n{$messagesS}\n\n"
			, $sl
		);
	}

	/**
	 * 2017-01-12
	 * @used-by ju_assert_sne()
	 * @used-by ju_param_sne()
	 * @used-by ju_result_sne()
	 */
	const NES = 'A non-empty string is required, but got an empty one.';

	/**
	 * Объект @see Frame конструируется на основе $o + 2,
	 * потому что нам нужно вернуть название метода, который вызвал тот метод, который вызвал метод caller.
	 * @used-by self::raiseErrorParam()
	 * @used-by self::raiseErrorResult()
	 * @used-by self::raiseErrorVariable()
	 */
	private static function caller(int $o):Frame {return Frame::i(ju_bt(0, 3 + $o)[2 + $o]);}

	/**
	 * @used-by self::raiseErrorParam()
	 * @used-by self::raiseErrorResult()
	 * @used-by self::raiseErrorVariable()
	 * 2015-01-28
	 * @throws E
	 */
	private static function throwException(string $message, int $sl = 0):void {ju_error(new E($message, ++$sl));}
	
	/**
	 * @param mixed $v
	 * @return mixed
	 * @throws E
	 */
	private static function vv(Vd $vd, $v, int $sl = 1) {return $vd->isValid($v) ? $v : self::raiseErrorVariable(
		get_class($vd), $vd->getMessages(), ++$sl
	);}
}