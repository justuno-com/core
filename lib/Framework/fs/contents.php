<?php
/**
 * 2022-11-24
 * 2023-07-26 "Unify `df_contents` and `df_file_read`": https://github.com/mage2pro/core/issues/275
 * @used-by ju_module_name_by_path()
 * @used-by ju_package()
 * @used-by ju_request_body()
 * @param Closure|bool|mixed $onE [optional]
 * @param ?resource $rs [optional]
 */
function ju_contents(string $f, $onE = true, $rs = null):string {
	# 2023-07-26
	# 1) "`df_contents()` should accept internal paths": https://github.com/mage2pro/core/issues/273
	# 2) df_is_url('php://input') returns `true`:
	# https://github.com/mage2pro/core/issues/277
	# https://3v4l.org/mTt87
	if (!ju_is_url($f)) {
		$f = ju_path_abs($f);
	}
	return ju_try(
		/**
		 * 2015-11-27
		 * Обратите внимание, что для использования @uses file_get_contents
		 * с адресами https требуется расширение php_openssl интерпретатора PHP,
		 * однако оно является системным требованием Magento 2:
		 * http://devdocs.magento.com/guides/v2.0/install-gde/system-requirements.html#required-php-extensions
		 * Поэтому мы вправе использовать здесь @uses file_get_contents
		 * 2016-05-31, 2022-10-14
		 * file_get_contents() could generate @see E_WARNING: e.g.:
		 * 	*) if the file is absent
		 * 	*)  in the case of network errors:
		 * 			«failed to open stream: A connection attempt failed
		 * 			because the connected party did not properly respond after a period of time,
		 * 			or established connection failed because connected host has failed to respond.»
		 * https://php.net/manual/function.file-get-contents.php#refsect1-function.file-get-contents-errors
		 * That is why I use the silence operator.
		 * 2023-07-16
		 * «file_get_contents(): Passing null to parameter #2 ($use_include_path) of type bool is deprecated
		 * in vendor/mage2pro/core/Framework/lib/fs/contents.php on line 36»:
		 * https://github.com/mage2pro/core/issues/230
		 */
		function() use ($f, $rs):string {return ju_assert_ne(false, @file_get_contents($f, false, $rs));}
		,true !== $onE ? $onE : function() use ($f) {ju_error(
			'Unable to read the %s «%s».', ju_is_url($f) ? 'URL' : 'file', $f
		);}
	);
}