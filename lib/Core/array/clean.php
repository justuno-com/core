<?php
/**
 * 2015-02-07
 * 2020-06-18 "Port the `df_clean` function": https://github.com/justuno-com/core/issues/58
 * @used-by ju_ccc()
 * @used-by ju_kv()
 * @used-by \Justuno\Core\Html\Tag::openTagWithAttributesAsText()
 * @used-by \Justuno\Core\Sentry\Client::capture()
 * @used-by \Justuno\Core\Sentry\Client::send()
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @param mixed ...$k [optional]
 */
function ju_clean(array $r, ...$k):array {/** @var mixed[] $r */return ju_clean_r(
	$r, array_merge([false], ju_args($k)), false
);}

/**
 * 2020-02-05
 * 2020-06-18 "Port the `df_clean_r` function": https://github.com/justuno-com/core/issues/59
 * @see ju_clean()
 * 1) It works recursively.
 * 2) I does not remove `false`.
 * @used-by ju_clean()
 * @used-by ju_clean_r()
 */
function ju_clean_r(array $r, array $k = [], bool $req = true):array {/** @var mixed[] $r */
	/** 2020-02-05 @see array_unique() does not work correctly here, even with the @see SORT_REGULAR flag. */
	$k = array_merge($k, ['', null, []]);
	if ($req) {
		$r = ju_map($r, function($v) use($k) {return !is_array($v) ? $v : ju_clean_r($v, $k);});
	}
	return ju_filter($r, function($v) use($k):bool {return !in_array($v, $k, true);});
}

/**
 * 2016-11-08
 * 2020-02-05 Now it correcly handles non-associative arrays.
 * 2020-06-18 "Port the `df_filter` function": https://github.com/justuno-com/core/issues/61
 * @used-by ju_clean_r()
 * @param callable|array(int|string => mixed)|array[]\Traversable $a1
 * @param callable|array(int|string => mixed)|array[]|\Traversable $a2
 * @return array(int|string => mixed)
 */
function ju_filter($a1, $a2):array { /** @var array $r */
	# 2020-03-02, 2022-10-31
	# 1) Symmetric array destructuring requires PHP ≥ 7.1:
	#		[$a, $b] = [1, 2];
	# https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	# We should support PHP 7.0.
	# https://3v4l.org/3O92j
	# https://www.php.net/manual/migration71.new-features.php#migration71.new-features.symmetric-array-destructuring
	# https://stackoverflow.com/a/28233499
	list($a, $f) = juaf($a1, $a2); /** @var array|Traversable $a */ /** @var callable $f */
	$a = ju_ita($a);
	$r = array_filter(ju_ita($a), $f);
	/**
	 * 2017-02-16
	 * Если исходный массив был неассоциативным, то после удаления из него элементов в индексах будут бреши.
	 * Это может приводить к неприятным последствиям:
	 * 1) @see df_is_assoc() для такого массива уже будет возвращать false, а не true, как для входного массива.
	 * 2) @see df_json_encode() будет кодировать такой массив как объект, а не как массив,
	 * что может привести (и приводит, например, у 2Checkout) к сбоям различных API
	 * 3) Последующие алгоритмы, считающие, что массив — неассоциативный, могут работать сбойно.
	 * По всем этим причинам привожу результат к неассоциативному виду, если исходный массив был неассоциативным.
	 */
	return ju_is_assoc($a) ? $r : array_values($r);
}