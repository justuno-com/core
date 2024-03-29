<?php
use Justuno\Core\Exception as DFE;

/**
 * 2020-06-13 "Port the `dfa_merge_numeric` function": https://github.com/justuno-com/core/issues/14
 * Plain `array_merge($r, $b)` works wronly,
 * if $b contains contains SOME numeric-string keys like "99":
 * https://github.com/mage2pro/core/issues/40#issuecomment-340139933
 * https://stackoverflow.com/a/5929671
 * @used-by jua_select_ordered()
 * @param array(string|int => mixed) $r
 * @param array(string|int => mixed) $b
 * @return array(string|int => mixed)
 */
function jua_merge_numeric(array $r, array $b):array {
	foreach ($b as $k => $v) {
		$r[$k] = $v;
	}
	return $r;
}

/**
 * 2015-02-18
 * 1) По смыслу функция @see jua_merge_r() аналогична методу @see \Magento\Framework\Simplexml\Element::extend()
 * и предназначена для слияния настроечных опций,
 * только, в отличие от @see \Magento\Framework\Simplexml\Element::extend(),
 * @see jua_merge_r() сливает не XML, а ассоциативные массивы.
 * 3) Вместо @see jua_merge_r() нельзя использовать ни
 * @see array_replace_recursive(), ни @see array_merge_recursive(),
 * ни тем более @see array_replace() и @see array_merge()
 * 3.1) Нерекурсивные аналоги отметаются сразу, потому что не способны сливать вложенные структуры.
 * 3.2) Но и стандартные рекурсивные функции тоже не подходят:
 * 3.2.1) array_merge_recursive(['width' => 180], ['width' => 200]) вернёт: ['width' => [180, 200]]
 * https://php.net/manual/function.array-merge-recursive.php
 * 3.2.2) Наша функция jua_merge_r(['width' => 180], ['width' => 200]) вернёт ['width' => 200]
 * 3.2.3) array_replace_recursive(['x' => ['A', 'B']], ['x' => 'C']) вернёт: ['x' => ['С', 'B']]
 * https://php.net/manual/function.array-replace-recursive.php
 * 3.2.4) Наша функция jua_merge_r(['x' => ['A', 'B']], ['x' => 'C']) вернёт ['x' => 'C']
 * 2018-11-13
 * 1) jua_merge_r(
 *		['TBCBank' => ['1111' => ['a' => 'b']]]
 *		,['TBCBank' => ['2222' => ['c' => 'd']]]
 * )
 * is: 'TBCBank' => ['1111' => ['a' => 'b'], '2222' => ['c' => 'd']]
 * 2) jua_merge_r(
 *		['TBCBank' => [1111 => ['a' => 'b']]]
 *		,['TBCBank' => [2222 => ['c' => 'd']]]
 * )
 * is: 'TBCBank' => [1111 => ['a' => 'b'], 2222 => ['c' => 'd']]
 * @used-by jua_merge_r()
 * @used-by ju_log()
 * @used-by ju_log_l()
 * @used-by ju_sentry()
 * @param array(string => mixed) $old
 * @param array(string => mixed) $new
 * @return array(string => mixed)
 * @throws DFE
 */
function jua_merge_r(array $old, array $new):array {
	# Здесь ошибочно было бы $r = [], потому что если ключ отсутствует в $new, то тогда он не попадёт в $r.
	$r = $old; /** @var array(string => mixed) $r */
	foreach ($new as $k => $newV) {/** @var int|string $k */ /** @var mixed $newV */
		if (is_null($newV))	{
			unset($r[$k]); ## 2016-08-23
		}
		else {
			/** 2023-07-29 I have removed @see jua() to improve speed. */
			$oldV = isset($old[$k]) ? $old[$k] : null; /** @var mixed $oldV */
			if (is_array($oldV) && is_array($newV)) {
				$r[$k] = jua_merge_r($oldV, $newV);
			}
			else {
				$r[$k] = $newV;
			}
		}
	}
	return $r;
}