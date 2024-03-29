<?php
use Magento\Framework\App\Filesystem\DirectoryList as DL;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\Write as DirectoryWrite;
use Magento\Framework\Filesystem\Directory\WriteInterface as IDirectoryWrite;
use Magento\Framework\Filesystem\File\Write as FileWrite;
use Magento\Framework\Filesystem\File\WriteInterface as IFileWrite;

/**
 * 2015-11-29
 * 2015-11-30
 * @see \Magento\Framework\Filesystem\Directory\Write::openFile() creates the parent directories automatically:
 * https://github.com/magento/magento2/blob/2.0.0/lib/internal/Magento/Framework/Filesystem/Directory/Write.php#L247
 * 2017-04-03 The possible directory types for filesystem operations: https://mage2.pro/t/3591
 * 2018-07-06 The `$append` parameter has been added.
 * 2020-02-14 If $append is `true`, then $contents will be written on a new line.
 * 2020-06-21 "Port the `ju_file_write` function": https://github.com/justuno-com/core/issues/99
 * @used-by ju_report()
 * @param string|string[] $p
 */
function ju_file_write($p, string $contents, bool $append = false):void {
	/** @var string $type */ /** @var string $relative */
	# 2020-03-02, 2022-10-31
	# 1) Symmetric array destructuring requires PHP ≥ 7.1:
	#		[$a, $b] = [1, 2];
	# https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	# We should support PHP 7.0.
	# https://3v4l.org/3O92j
	# https://php.net/manual/migration71.new-features.php#migration71.new-features.symmetric-array-destructuring
	# https://stackoverflow.com/a/28233499
	list($type, $relative) = is_array($p) ? $p : [DL::ROOT, ju_path_relative($p)];
	$writer = ju_fs_w($type); /** @var DirectoryWrite|IDirectoryWrite $writer */
	# 2018-07-06
	# «'w':	Open for writing only;
	# 		place the file pointer at the beginning of the file and truncate the file to zero length.
	# 		If the file does not exist, attempt to create it.
	# 'a'	Open for writing only; place the file pointer at the end of the file.
	# 		If the file does not exist, attempt to create it.
	# 		In this mode, fseek() has no effect, writes are always appended.»
	# https://php.net/manual/function.fopen.php#refsect1-function.fopen-parameters
	$file = $writer->openFile($relative, $append ? 'a' : 'w'); /** @var IFileWrite|FileWrite $file */
	/**
	 * 2015-11-29
	 * By analogy with @see \Magento\MediaStorage\Model\File\Storage\Synchronization::synchronize()
	 * https://github.com/magento/magento2/blob/2.0.0/app/code/Magento/MediaStorage/Model/File/Storage/Synchronization.php#L61-L68
	 * Please note the following comments:
	 *
	 * 1) https://mage2.pro/t/274
	 * «\Magento\MediaStorage\Model\File\Storage\Synchronization::synchronize() wrongly leaves a file in the locked state in case of an exception»
	 *
	 * 2) https://mage2.pro/t/271
	 * «\Magento\MediaStorage\Model\File\Storage\Synchronization::synchronize() suppresses its exceptions for a questionably reason»
	 *
	 * 3) https://mage2.pro/t/272
	 * «\Magento\MediaStorage\Model\File\Storage\Synchronization::synchronize() duplicates the code in the try and catch blocks, propose to use a «finally» block»
	 *
	 * 4) https://mage2.pro/t/273
	 * «\Magento\MediaStorage\Model\File\Storage\Synchronization::synchronize() contains a wrong PHPDoc comment for the $file variable»
	 */
	try {
		$file->lock();
		try {
			/**
			 * 2018-07-06
			 * Note 1. https://stackoverflow.com/a/4857194
			 * Note 2.
			 * @see ftell() and @see \Magento\Framework\Filesystem\File\Read::tell() do not work here
			 * even if the file is opened in the `a+` mode:
			 * https://php.net/manual/function.ftell.php#116885
			 * «When opening a file for reading and writing via fopen('file','a+')
			 * the file pointer should be at the end of the file.
			 * However ftell() returns int(0) even if the file is not empty.»
			 */
			if ($append && 0 !== filesize(BP . "/$relative")) {
				$contents = PHP_EOL . $contents; # 2018-07-06 «PHP fwrite new line» https://stackoverflow.com/a/15130410
			}
			$file->write($contents);
		}
		finally {$file->unlock();}
	}
	finally {$file->close();}
}

/**
 * 2015-11-29
 * 2020-06-21 "Port the `df_fs` function": https://github.com/justuno-com/core/issues/101
 * @used-by ju_sys_reader()
 * @used-by ju_fs_w()
 */
function ju_fs():Filesystem {return ju_o(Filesystem::class);}

/**
 * 2015-11-29
 * 2017-04-03 The possible directory types for filesystem operations: https://mage2.pro/t/3591
 * 2020-06-21 "Port the `df_fs_w` function": https://github.com/justuno-com/core/issues/100
 * @used-by ju_file_write()
 * @return DirectoryWrite|IDirectoryWrite
 */
function ju_fs_w(string $type) {return ju_fs()->getDirectoryWrite($type);}