<?php
/**
 * 2015-04-05
 * 2020-06-18 "Port the `df_type` function": https://github.com/justuno-com/core/issues/80
 * @used-by ju_assert_gd()
 * @param mixed $v
 * @return string
 */
function ju_type($v) {return is_object($v) ? sprintf('an object: %s', get_class($v), df_dump($v)) : (is_array($v)
	? (10 < ($c = count($v)) ? "«an array of $c elements»" : 'an array: ' . df_dump($v))
	/** 2020-02-04 We should not use @see df_desc() here */
	: (is_null($v) ? '`null`' : sprintf('«%s» (%s)', df_string($v), gettype($v)))
);}