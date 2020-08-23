<?php
use Exception as E;
use Justuno\Core\Exception as DFE;
use Justuno\Core\Qa\Method as Q;
use Justuno\Core\Zf\Validate\StringT\IntT;

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
 * @used-by ju_assert_qty_supported()
 * @used-by ju_module_dir()
 * @used-by juaf()
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodParameter()
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodParameter()
 * @param mixed $cond
 * @param string|E|null $m [optional]
 * @return mixed
 * @throws DFE
 */
function ju_assert($cond, $m = null) {return $cond ?: ju_error($m);}

/**
 * 2020-08-19 "Port the `df_assert_lt` function" https://github.com/justuno-com/core/issues/203
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodParameter()
 * @param int|float $highBound
 * @param int|float $v
 * @param string|E $m [optional]
 * @return int|float
 * @throws DFE
 */
function ju_assert_lt($highBound, $v, $m = null) {return $highBound >= $v ? $v : ju_error($m ?:
	"A number < {$highBound} is expected, but got {$v}."
);}

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
 * 2017-01-14
 * 2020-08-19 "Port the `df_assert_nef` function" https://github.com/justuno-com/core/issues/201
 * @used-by \Justuno\Core\Qa\Trace\Frame::context()
 * @param mixed $v
 * @param string|E $m [optional]
 * @return mixed
 * @throws DFE
 */
function ju_assert_nef($v, $m = null) {return false !== $v ? $v : ju_error($m ?:
	'The «false» value is rejected, any others are allowed.'
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

/**
 * 2016-08-09
 * 2020-08-21 "Port the `ju_assert_traversable` function" https://github.com/justuno-com/core/issues/222
 * @used-by juaf()
 * @param \Traversable|array $v
 * @param string|E $m [optional]
 * @return \Traversable|array
 * @throws DFE
 */
function ju_assert_traversable($v, $m = null) {return ju_check_traversable($v) ? $v : ju_error($m ?:
	'A variable is expected to be a traversable or an array, ' . 'but actually it is %s.', ju_type($v)
);}

/**
 * 2020-08-23 "Port the `ju_int` function" https://github.com/justuno-com/core/issues/287
 * @used-by ju_product_id()
 * @used-by \Justuno\Core\Zf\Validate\IntT::filter()
 * @param mixed|mixed[] $v
 * @param bool $allowNull [optional]
 * @return int|int[]
 * @throws DFE
 */
function ju_int($v, $allowNull = true) {/** @var int|int[] $r */
	if (is_array($v)) {
		$r = ju_map(__FUNCTION__, $v, $allowNull);
	}
	else {
		if (is_int($v)) {
			$r = $v;
		}
		elseif (is_bool($v)) {
			$r = $v ? 1 : 0;
		}
		else {
			if ($allowNull && (is_null($v) || ('' === $v))) {
				$r = 0;
			}
			else {
				if (!IntT::s()->isValid($v)) {
					ju_error(IntT::s()->getMessage());
				}
				else {
					$r = (int)$v;
				}
			}
		}
	}
	return $r;
}