<?php
use Justuno\Core\Exception as DFE;
use Justuno\Core\Qa\Method as Q;
/**
 * 2020-06-22 "Port the `df_result_s` function": https://github.com/justuno-com/core/issues/108
 * @used-by ju_result_sne()
 * @param mixed $v
 * @throws DFE
 */
function ju_result_s($v, int $sl = 0):string {return ju_check_s($v) ? $v : Q::raiseErrorResult(
	__FUNCTION__, [sprintf('A string is required, but got %s.', ju_type($v))], ++$sl
);}

/**
 * 2020-06-22 "Port the `df_result_sne` function": https://github.com/justuno-com/core/issues/107
 * @used-by ju_dts()
 * @throws DFE
 */
function ju_result_sne(string $v, int $sl = 0):string {$sl++;
	ju_result_s($v, $sl);
	return '' !== strval($v) ? $v : Q::raiseErrorResult(__FUNCTION__, [Q::NES], $sl);
}