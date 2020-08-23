<?php
use Exception as E;
use Justuno\Core\Exception as DFE;

/**
 * 2020-08-19 "Port the `df_assert_lt` function" https://github.com/justuno-com/core/issues/203
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodParameter()
 * @param int|float $highBound
 * @param int|float $v
 * @param string|E|null $m [optional]
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
 * @param string|E|null $m [optional]
 * @return string|int|float|bool
 * @throws DFE
 */
function ju_assert_ne($neResult, $v, $m = null) {return $neResult !== $v ? $v : ju_error($m ?:
	"The value {$v} is rejected, any other is allowed."
);}
