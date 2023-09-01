<?php
/**
 * 2016-08-10
 * 2020-08-19 "Port the `df_cc_method` function" https://github.com/justuno-com/core/issues/202
 * @used-by \Justuno\Core\Qa\Trace\Frame::method()
 * @param string|object|null|array(object|string)|array(string = string) $a1
 * @param string|null $a2 [optional]
 * @return string
 */
function ju_cc_method($a1, $a2 = null):string {return ju_ccc('::',
	$a2 ? [ju_cts($a1), $a2] : (
		!isset($a1['function']) ? $a1 :
			[jua($a1, 'class'), $a1['function']]
	)
);}