<?php
use Justuno\Core\Exception as DFE;
use Df\Qa\Method as Q;

/**
 * 2020-06-15 "Port the `df_param_sne` function": https://github.com/justuno-com/core/issues/22
 * @used-by jua_deep()
 * @param string $v
 * @param int $ord	zero-based
 * @param int $sl [optional]
 * @return string
 * @throws DFE
 */
function ju_param_sne($v, $ord, $sl = 0) {$sl++;
	Q::assertValueIsString($v, $sl);
	return '' !== strval($v) ? $v : Q::raiseErrorParam(__FUNCTION__, $ms = [Q::NES], $ord, $sl);
}