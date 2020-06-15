<?php
use Justuno\Core\Exception as DFE;
use Exception as E;
use Magento\Framework\Phrase;
/**
 * 2020-06-15 "Port the `df_ets` function": https://github.com/justuno-com/core/issues/24
 * @used-by \Justuno\Core\Exception::__construct()
 * @param E|string|Phrase $e
 * @return string|Phrase
 */
function ju_ets($e) {return df_adjust_paths_in_message(
	!$e instanceof E ? $e : ($e instanceof DFE ? $e->message() : $e->getMessage())
);}