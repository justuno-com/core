<?php
/**
 * 2016-11-08
 * 2020-02-05 Now it correcly handles non-associative arrays.
 * 2020-06-18 "Port the `df_filter` function": https://github.com/justuno-com/core/issues/61
 * @used-by ju_clean_r()
 * @param callable|array(int|string => mixed)|array[]\Traversable $a1
 * @param callable|array(int|string => mixed)|array[]|\Traversable $a2
 * @return array(int|string => mixed)
 */
function ju_filter($a1, $a2):array {return ju_filter_f($a1, $a2, 'array_filter');}

/**
 * 2023-07-26
 * @used-by ju_filter()
 * @used-by ju_filter_head()
 * @used-by ju_filter_tail()
 * @param callable|array(int|string => mixed)|array[]Traversable $a1
 * @param callable|array(int|string => mixed)|array[]|Traversable $a2
 * @param callable $fA
 * @return array(int|string => mixed)
 */
function ju_filter_f($a1, $a2, $fA):array {/** @var array $r */
	# 2020-03-02, 2022-10-31
	# 1) Symmetric array destructuring requires PHP ≥ 7.1:
	#		[$a, $b] = [1, 2];
	# https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	# We should support PHP 7.0.
	# https://3v4l.org/3O92j
	# https://php.net/manual/migration71.new-features.php#migration71.new-features.symmetric-array-destructuring
	# https://stackoverflow.com/a/28233499
	list($a, $fI) = juaf($a1, $a2); /** @var iterable $a */ /** @var callable $fI */
	$a = ju_ita($a);
	$r = call_user_func($fA, $a, $fI);
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

/**
 * 2023-07-26 "Implement `df_filter_head()`": https://github.com/mage2pro/core/issues/264
 * @used-by \Justuno\Core\Qa\Trace::__construct()
 * @param callable|array(int|string => mixed)|array[]Traversable $a1
 * @param callable|array(int|string => mixed)|array[]|Traversable $a2
 * @return array(int|string => mixed)
 */
function ju_filter_head($a1, $a2):array {return ju_filter_f($a1, $a2, function(array $a, $f):array {
	$r = [];
	foreach ($a as $k => $v) {/** @var int|string $k */ /** @var mixed $v */
		if (!$r && call_user_func($f, $v)) {
			continue;
		}
		$r[$k] = $v;
	}
	return $r;
});}

/**
 * 2023-07-26 "Implement `df_filter_tail()`": https://github.com/mage2pro/core/issues/263
 * @used-by \Justuno\Core\Qa\Trace::__construct()
 * @param callable|array(int|string => mixed)|array[]Traversable $a1
 * @param callable|array(int|string => mixed)|array[]|Traversable $a2
 * @return array(int|string => mixed)
 */
function ju_filter_tail($a1, $a2):array {return ju_filter_f($a1, $a2, function(array $a, $f):array {
	$r = [];
	foreach ($a as $k => $v) {/** @var int|string $k */ /** @var mixed $v */
		if (call_user_func($f, $v)) {
			break;
		}
		$r[$k] = $v;
	}
	return $r;
});}