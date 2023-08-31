<?php
/**
 * 2023-08-01
 * @used-by ju_bt_entry_is_phtml()
 * @used-by \Justuno\Core\Qa\Trace\Frame::isPHTML()
 */
function ju_is_phtml(string $f):bool {return ju_ends_with($f, '.phtml');}

/**
 * 2023-08-01
 * @used-by ju_block()
 */
function ju_phtml_add_ext(string $f):string {return ju_file_ext_add($f, '.phtml');}