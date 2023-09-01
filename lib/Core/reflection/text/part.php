<?php
/**
 * 2016-01-01
 * 2016-10-20
 * Making $c optional leads to the error «get_class() called without object from outside a class»: https://3v4l.org/k6Hd5
 * 2020-08-22 "Port the `ju_class_f` function" https://github.com/justuno-com/core/issues/264
 * @used-by ju_class_my()
 * @param string|object $c
 */
function ju_class_f($c):string {return ju_first(ju_explode_class($c));}

/**
 * 2015-12-29
 * 2016-10-20
 * Нельзя делать параметр $c опциональным, потому что иначе получим сбой:
 * «get_class() called without object from outside a class»
 * https://3v4l.org/k6Hd5
 * 2020-08-19 "Port the `df_class_l` function" https://github.com/justuno-com/core/issues/199
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @used-by \Justuno\M2\Response::p()
 * @param string|object $c
 */
function ju_class_l($c):string {return ju_last(ju_explode_class($c));}