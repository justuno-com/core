<?php
use Justuno\Core\Exception as DFE;
use Exception as E;
use Magento\Framework\Phrase;
/**
 * 2020-06-15 "Port the `df_ets` function": https://github.com/justuno-com/core/issues/24
 * @used-by ju_sprintf_strict()
 * @used-by \Justuno\Core\Exception::__construct()
 * @used-by \Justuno\Core\Qa\Message::log()
 * @param E|string|Phrase $e
 * @return string|Phrase
 */
function ju_ets($e) {return ju_adjust_paths_in_message(
	!$e instanceof E ? $e : ($e instanceof DFE ? $e->message() : $e->getMessage())
);}

/**
 * 2016-07-31
 * 2020-06-17 "Port the `df_ewrap` function": https://github.com/justuno-com/core/issues/38
 * @used-by ju_error_create()
 * @param E $e
 * @return DFE
 */
function ju_ewrap($e) {return DFE::wrap($e);}