<?php
/**
 * 2015-02-07
 * 2020-08-13
 * 1) df_csv(['aaa', 'bbb', 'ccc']) → 'aaa,bbb,ccc'
 * df_csv_pretty(['aaa', 'bbb']) → 'aaa, bbb, ccc'
 * 2) "Port the `df_csv_pretty` function": https://github.com/justuno-com/core/issues/170
 * @see df_csv()
 * @used-by \Justuno\Core\Sentry\Client::send()
 * @used-by \Justuno\M2\Catalog\Diagnostic::p()
 * @param string|string[] $a
 */
function ju_csv_pretty(...$a):string {return implode(', ', jua_flatten($a));}