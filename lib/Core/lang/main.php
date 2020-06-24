<?php
use Closure as F;
use Exception as E;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * 2020-06-17 "Port the `df_args` function": https://github.com/justuno-com/core/issues/41
 * @used-by ju_clean()
 * @used-by ju_format()
 * @param mixed[] $a
 * @return mixed[]
 */
function ju_args(array $a) {return !$a || !is_array($a[0]) ? $a : $a[0];}

/**
 * 2020-06-13 "Port the `df_if1` function": https://github.com/justuno-com/core/issues/10
 * @used-by ju_request()
 * @param bool $cond
 * @param mixed|callable $onTrue
 * @param mixed|null $onFalse [optional]
 * @return mixed
 */
function ju_if1($cond, $onTrue, $onFalse = null) {return $cond ? ju_call_if($onTrue) : $onFalse;}

/**
 * 2017-04-15
 * 2020-06-18 "Port the `df_try` function": https://github.com/justuno-com/core/issues/75
 * @used-by ju_gd()
 * @used-by ju_trim()
 * @used-by ju_zuri()
 * @param F $try
 * @param F|bool|mixed $onE [optional]
 * @return mixed
 * @throws E
 */
function ju_try(F $try, $onE = null) {
	try {return $try();}
	catch(E $e) {return $onE instanceof F ? $onE($e) : (true === $onE ? ju_error($e) : $onE);}
}