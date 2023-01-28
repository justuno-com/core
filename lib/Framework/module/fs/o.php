<?php
use Magento\Framework\Module\Dir\Reader;

/**
 * 2019-12-31
 * 2020-06-26 "Port the `df_module_dir_reader` function": https://github.com/justuno-com/core/issues/148
 * @used-by ju_module_dir()
 */
function ju_module_dir_reader():Reader {return ju_o(Reader::class);}