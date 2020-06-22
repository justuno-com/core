<?php
use Justuno\Core\Qa\Method as Q;
use Justuno\Core\Exception as DFE;

/**
 * 2017-04-22
 * 2020-06-20 "Port the `df_param_s` function": https://github.com/justuno-com/core/issues/94
 * @used-by ju_file_write()
 * @used-by ju_report()
 * @param string $v
 * @param int $ord	zero-based
 * @param int $sl [optional]
 * @return string
 * @throws DFE
 */
function ju_param_s($v, $ord, $sl = 0) {$sl++;
	return Q::assertValueIsString($v, $sl) ? $v : Q::raiseErrorParam(__FUNCTION__, $ms = [Q::S], $ord, $sl);
}

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