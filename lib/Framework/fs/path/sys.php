<?php
use Magento\Framework\Filesystem\Directory\Read as DirectoryRead;
use Magento\Framework\Filesystem\Directory\ReadInterface as IDirectoryRead;

/**
 * 2015-11-30
 * 2020-08-21 "Port the `df_fs_r` function" https://github.com/justuno-com/core/issues/226
 * @used-by ju_path_relative()
 * @return DirectoryRead|IDirectoryRead
 */
function ju_sys_reader(string $p) {return ju_fs()->getDirectoryRead($p);}