<?php
use Justuno\Core\Exception as DFE;
use Justuno\Core\Qa\Method as Q;
/**
 * 2020-06-22 "Port the `df_result_sne` function": https://github.com/justuno-com/core/issues/107
 * @used-by ju_dts()
 * @param string $v
 * @param int $sl [optional]
 * @return string
 * @throws DFE
 */
function ju_result_sne($v, $sl = 0) {$sl++;
	df_result_s($v, $sl);
	return '' !== strval($v) ? $v : Q::raiseErrorResult(__FUNCTION__, [Q::NES], $sl);
}