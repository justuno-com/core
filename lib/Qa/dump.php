<?php
use Justuno\Core\Qa\Dumper;
/**
 * We do not use @uses \Justuno\Core\Qa\Dumper as a singleton
 * because @see \Justuno\Core\Qa\Dumper::dumpObject()
 * uses the @see \Justuno\Core\Qa\Dumper::$_dumped property to avoid a recursion.
 * 2020-06-18 "Port the `df_dump` function": https://github.com/justuno-com/core/issues/81
 * @used-by ju_assert_eq()
 * @used-by ju_dump_ds()
 * @used-by ju_sentry()
 * @used-by ju_type()
 * @used-by juc()
 * @used-by \Justuno\Core\Sentry\Client::capture()
 * @param mixed $v
 */
function ju_dump($v):string {return Dumper::i()->dump($v);}

/**
 * 2023-08-04
 * @used-by ju_log_l()
 */
function ju_dump_ds($v):string {return ju_json_dont_sort(function() use($v):string {return ju_dump($v);});}

/**
 * 2015-04-05
 * 2020-06-18 "Port the `df_type` function": https://github.com/justuno-com/core/issues/80
 * 2022-10-14 @see get_debug_type() has been added to PHP 8: https://php.net/manual/function.get-debug-type.php
 * @used-by ju_assert_gd()
 * @used-by ju_assert_traversable()
 * @used-by ju_customer()
 * @used-by ju_result_s()
 * @used-by juaf()
 * @param mixed $v
 */
function ju_type($v):string {return is_object($v) ? sprintf('an object: %s', get_class($v), ju_dump($v)) : (is_array($v)
	? (10 < ($c = count($v)) ? "«an array of $c elements»" : 'an array: ' . ju_dump($v))
	/** 2020-02-04 We should not use @see df_desc() here */
	: (is_null($v) ? '`null`' : sprintf('«%s» (%s)', ju_string($v), gettype($v)))
);}