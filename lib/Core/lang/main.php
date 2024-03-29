<?php
use Closure as F;
use Throwable as Th; # 2023-08-30 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401

/**
 * 2020-08-23 "Port the `df_if` function" https://github.com/justuno-com/core/issues/294
 * @used-by ju_cfg()
 * @param mixed|callable $onTrue
 * @param mixed|null|callable $onFalse [optional]
 * @return mixed
 */
function ju_if(bool $cond, $onTrue, $onFalse = null) {return $cond ? ju_call_if($onTrue) : ju_call_if($onFalse);}

/**
 * 2020-06-13 "Port the `df_if1` function": https://github.com/justuno-com/core/issues/10
 * @used-by ju_request()
 * @param mixed|callable $onTrue
 * @param mixed|null $onFalse [optional]
 * @return mixed
 */
function ju_if1(bool $cond, $onTrue, $onFalse = null) {return $cond ? ju_call_if($onTrue) : $onFalse;}

/**
 * 2020-08-22 "Port the `df_nop` function" https://github.com/justuno-com/core/issues/255
 * @used-by \Justuno\Core\Html\Tag::openTagWithAttributesAsText()
 * @param mixed $v
 * @return mixed
 */
function ju_nop($v) {return $v;}

/**
 * 2017-04-15
 * 2020-06-18 "Port the `df_try` function": https://github.com/justuno-com/core/issues/75
 * @used-by ju_gd()
 * @used-by ju_customer()
 * @used-by ju_date_from_db()
 * @used-by ju_layout_update()
 * @used-by ju_module_file_name()
 * @used-by ju_product_current()
 * @used-by ju_trim()
 * @used-by ju_zuri()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @used-by \Justuno\Core\Qa\Trace\Frame::functionA()
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodR()
 * @param F|bool|mixed $onE [optional]
 * @return mixed
 * @throws Th
 */
function ju_try(F $try, $onE = null) {
	try {return $try();}
	catch(Th $th) {return $onE instanceof F ? $onE($th) : (true === $onE ? ju_error($th) : $onE);}
}