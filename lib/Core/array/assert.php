<?php
/**
 * 2023-07-26 "Implement `dfa_has_keys()`": https://github.com/mage2pro/core/issues/258
 * @used-by ju_bt_entry_is_method()
 */
function jua_has_keys(array $a, array $kk):bool {return count($kk) === count(jua($a, $kk));}