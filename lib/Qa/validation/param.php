<?php
use Justuno\Core\Qa\Method as Q;
use Justuno\Core\Exception as DFE;

/**
 * 2020-06-15 "Port the `df_param_sne` function": https://github.com/justuno-com/core/issues/22
 * @used-by ju_date_from_db()
 * @used-by ju_xml_parse()
 * @used-by jua_deep()
 * @used-by jua_deep_unset()
 * @used-by \Justuno\Core\Html\Tag::openTagWithAttributesAsText()
 * @throws DFE
 */
function ju_param_sne(string $v, int $ord, int $sl = 0):string {$sl++;
	return '' !== strval($v) ? $v : Q::raiseErrorParam(__FUNCTION__, [Q::NES], $ord, $sl);
}