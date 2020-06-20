<?php
use Justuno\Core\Qa\Dumper;

/**
 * 2020-06-18 "Port the `df_dump` function": https://github.com/justuno-com/core/issues/81
 * @used-by ju_type()
 * @param \Magento\Framework\DataObject|mixed[]|mixed $v
 * @return string
 */
function ju_dump($v) {return Dumper::i()->dump($v);}

/**
 * 2015-04-05
 * 2020-06-18 "Port the `df_type` function": https://github.com/justuno-com/core/issues/80
 * @used-by ju_assert_gd()
 * @param mixed $v
 * @return string
 */
function ju_type($v) {return is_object($v) ? sprintf('an object: %s', get_class($v), ju_dump($v)) : (is_array($v)
	? (10 < ($c = count($v)) ? "«an array of $c elements»" : 'an array: ' . ju_dump($v))
	/** 2020-02-04 We should not use @see df_desc() here */
	: (is_null($v) ? '`null`' : sprintf('«%s» (%s)', ju_string($v), gettype($v)))
);}