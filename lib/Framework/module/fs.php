<?php
/**
 * 2015-11-15
 * 2015-09-02
 * @uses df_module_dir() and indirectly called @see \Magento\Framework\Module\Dir\Reader::getModuleDir()
 * use `/` insteads @see DIRECTORY_SEPARATOR as a path separator, so I use `/` too.
 * 2016-11-17
 * $m could be:
 * 1) a module name: «A_B»
 * 2) a class name: «A\B\C».
 * 3) an object: it comes down to the case 2 via @see get_class()
 * 4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2020-06-26 "Port the `df_module_path` function": https://github.com/justuno-com/core/issues/146
 * @used-by ju_package()
 * @param string|object|null $m
 * @param string $localPath [optional]
 * @return string
 * @throws \InvalidArgumentException
 */
function ju_module_path($m, $localPath = '') {return ju_cc_path(df_module_dir($m), $localPath);}