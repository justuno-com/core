<?php
use Magento\Framework\App\Filesystem\DirectoryList as DL;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\Read as DirectoryRead;
use Magento\Framework\Filesystem\Directory\ReadFactory as DirectoryReadFactory;
use Magento\Framework\Filesystem\Directory\ReadInterface as IDirectoryRead;
use Magento\Framework\Filesystem\Directory\Write as DirectoryWrite;
use Magento\Framework\Filesystem\Directory\WriteInterface as IDirectoryWrite;
use Magento\Framework\Filesystem\File\Read as FileRead;
use Magento\Framework\Filesystem\File\ReadInterface as IFileRead;
use Magento\Framework\Filesystem\File\Write as FileWrite;
use Magento\Framework\Filesystem\File\WriteInterface as IFileWrite;
use Magento\Framework\Filesystem\Io\File as File;
use Magento\Framework\Filesystem\Io\Sftp;

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

/**
 * 2020-06-15 "Port the `df_adjust_paths_in_message` function": https://github.com/justuno-com/core/issues/25
 * @used-by ju_ets()
 * @param string $m
 * @return string
 */
function ju_adjust_paths_in_message($m) {
	$bpLen = mb_strlen(BP); /** @var int $bpLen */
	do {
		$begin = mb_strpos($m, BP); /** @var int|false $begin */
		if (false === $begin) {
			break;
		}
		$end = mb_strpos($m, '.php', $begin + $bpLen); /** @var int|false $end */
		if (false === $end) {
			break;
		}
		$end += 4; // 2016-12-23 It is the length of the «.php» suffix.
		$m =
			mb_substr($m, 0, $begin)
			// 2016-12-23 I use `+ 1` to cut off a slash («/» or «\») after BP.
			. ju_path_n(mb_substr($m, $begin + $bpLen + 1, $end - $begin - $bpLen - 1))
			. mb_substr($m, $end)
		;
	} while(true);
	return $m;
}

/**
 * 2015-11-28 http://stackoverflow.com/a/10368236
 * 2020-06-21 "Port the `df_file_ext` function": https://github.com/justuno-com/core/issues/97
 * @used-by ju_file_ext_def()
 * @param string $f
 * @return string
 */
function ju_file_ext($f) {return pathinfo($f, PATHINFO_EXTENSION);}

/**
 * 2018-07-06
 * 2020-06-21 "Port the `df_file_ext_def` function": https://github.com/justuno-com/core/issues/96
 * @used-by ju_report()
 * @param string $f
 * @param string $ext
 * @return string
 */
function ju_file_ext_def($f, $ext) {return ($e = ju_file_ext($f)) ? $f : ju_trim_right($f, '.') . ".$ext";}

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
 * @param string $contents
 * @param bool $append [optional]
 */
function ju_file_write($p, $contents, $append = false) {
	ju_param_s($contents, 1);
	/** @var string $type */ /** @var string $relative */
	// 2020-03-02
	// The square bracket syntax for array destructuring assignment (`[…] = […]`) requires PHP ≥ 7.1:
	// https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	// We should support PHP 7.0.
	list($type, $relative) = is_array($p) ? $p : [DL::ROOT, df_path_relative($p)];
	$writer = ju_fs_w($type); /** @var DirectoryWrite|IDirectoryWrite $writer */
	/**
	 * 2018-07-06
	 * Note 1.
	 * https://php.net/manual/function.fopen.php#refsect1-function.fopen-parameters
	 * 'w':	Open for writing only;
	 * 		place the file pointer at the beginning of the file and truncate the file to zero length.
	 * 		If the file does not exist, attempt to create it.
	 * 'a'	Open for writing only; place the file pointer at the end of the file.
	 * 		If the file does not exist, attempt to create it.
	 * 		In this mode, fseek() has no effect, writes are always appended.
	 */
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
				// 2018-07-06 «PHP fwrite new line» https://stackoverflow.com/a/15130410
				$contents = PHP_EOL . $contents;
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
 * @used-by ju_fs_w()
 * @return Filesystem
 */
function ju_fs() {return ju_o(Filesystem::class);}

/**
 * 2015-11-29
 * 2017-04-03 The possible directory types for filesystem operations: https://mage2.pro/t/3591
 * 2020-06-21 "Port the `df_fs_w` function": https://github.com/justuno-com/core/issues/100
 * @used-by ju_file_write()
 * @param string $type
 * @return DirectoryWrite|IDirectoryWrite
 */
function ju_fs_w($type) {return ju_fs()->getDirectoryWrite($type);}

/**
 * 2020-06-15 "Port the `df_path_n` function": https://github.com/justuno-com/core/issues/26
 * @used-by ju_adjust_paths_in_message()
 * @param string $p
 * @return string
 */
function ju_path_n($p) {return str_replace('//', '/', str_replace('\\', '/', $p));}