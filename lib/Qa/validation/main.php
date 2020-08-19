<?php
use Df\Zf\Validate\StringT\FloatT;
use Df\Zf\Validate\StringT\IntT;
use Exception as E;
use Justuno\Core\Exception as DFE;
use Justuno\Core\Qa\Method as Q;

/**
 * 2019-12-14
 * If you do not want the exception to be logged via @see df_bt(),
 * then you can pass an empty string (instead of `null`) as the second argument:
 * @see \Df\Core\Exception::__construct():
 *		if (is_null($m)) {
 *			$m = __($prev ? df_ets($prev) : 'No message');
 *			# 2017-02-20 To facilite the «No message» diagnostics.
 *			if (!$prev) {
 *				df_bt();
 *			}
 *		}
 * https://github.com/mage2pro/core/blob/5.5.7/Core/Exception.php#L61-L67
 * 2020-06-17 "Port the `df_assert` function": https://github.com/justuno-com/core/issues/33
 * @used-by ju_module_dir()
 * @used-by juaf()
 * @param mixed $cond
 * @param string|E|null $m [optional]
 * @return mixed
 * @throws DFE
 */
function ju_assert($cond, $m = null) {return $cond ?: ju_error($m);}

/**
 * 2020-06-22 "Port the `df_assert_ne` function": https://github.com/justuno-com/core/issues/116
 * @used-by ju_file_name()
 * @used-by ju_json_decode()
 * @param string|int|float|bool $neResult
 * @param string|int|float|bool $v
 * @param string|E $m [optional]
 * @return string|int|float|bool
 * @throws DFE
 */
function ju_assert_ne($neResult, $v, $m = null) {return $neResult !== $v ? $v : ju_error($m ?:
	"The value {$v} is rejected, any other is allowed."
);}

/**
 * 2020-06-22 "Port the `df_assert_sne` function": https://github.com/justuno-com/core/issues/115
 * @used-by ju_file_name()
 * @param string $v
 * @param int $sl [optional]
 * @return string
 * @throws DFE
 */
function ju_assert_sne($v, $sl = 0) {
	$sl++;
	Q::assertValueIsString($v, $sl);
	# The previous code `if (!$v)` was wrong because it rejected the '0' string.
	return '' !== strval($v) ? $v : Q::raiseErrorVariable(__FUNCTION__, $ms = [Q::NES], $sl);
}