<?php
use Justuno\Core\Exception as DFE;
use Exception as E;
use Magento\Framework\Phrase as P;

/**
 * 2023-07-25
 * @used-by ju_log_l()
 * @used-by ju_x_module()
 */
function ju_x_entry(E $e):array {return ju_caller_entry($e, function(array $a):bool {return
	($c = ju_bt_entry_class($a)) && ju_module_enabled($c)
;});}

/**
 * 2023-07-25
 * @used-by ju_log()
 */
function ju_x_module(E $e):string {return ju_module_name(jua(ju_x_entry($e), 'class'));}

/**
 * 2016-07-18
 * 2020-08-21 "Port the `df_ef` function" https://github.com/justuno-com/core/issues/208
 * @used-by \Justuno\Core\Qa\Failure\Exception::trace()
 */
function ju_xf(E $e):E {while ($e->getPrevious()) {$e = $e->getPrevious();} return $e;}

/**
 * 2020-06-15 "Port the `df_ets` function": https://github.com/justuno-com/core/issues/24
 * @used-by ju_sprintf_strict()
 * @used-by ju_xml_parse()
 * @used-by \Justuno\Core\Exception::__construct()
 * @used-by \Justuno\Core\Qa\Failure\Exception::e()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @param E|P|string $e
 */
function ju_xts($e):string {return ju_adjust_paths_in_message(
	!$e instanceof E ? $e : ($e instanceof DFE ? $e->message() : $e->getMessage())
);}