<?php
use Justuno\Core\Helper\Text as T;
use Magento\Framework\Phrase as P;
/**
 * @used-by \Justuno\M2\Catalog\Diagnostic::p()
 * @param string|string[]|P|P[] $s
 * @return string|string[]
 */
function ju_quote_russian($s) {return ju_t()->quote($s, T::QUOTE__RUSSIAN);}