<?php
use Justuno\Core\Exception as DFE;

/**
 * 2015-02-18
 *  1) По смыслу функция @param array(string => mixed) $defaults
 * @param array(string => mixed) $newValues
 * @return array(string => mixed)
 * @throws DFE
 * @see ju_extend() аналогична методу @see \Magento\Framework\Simplexml\Element::extend()
 *  и предназначена для слияния настроечных опций,
 *  только, в отличие от @see \Magento\Framework\Simplexml\Element::extend(),
 * @see ju_extend() сливает не XML, а ассоциативные массивы.
 *  3) Вместо @see ju_extend() нельзя использовать ни
 * @see array_replace_recursive(), ни @see array_merge_recursive(),
 *  ни тем более @see array_replace() и @see array_merge()
 *  3.1) Нерекурсивные аналоги отметаются сразу, потому что не способны сливать вложенные структуры.
 *  3.2) Но и стандартные рекурсивные функции тоже не подходят:
 *  3.2.1) array_merge_recursive(['width' => 180], ['width' => 200]) вернёт: ['width' => [180, 200]]
 *  https://php.net/manual/function.array-merge-recursive.php
 *  3.2.2) Наша функция ju_extend(['width' => 180], ['width' => 200])вернёт ['width' => 200]
 *  3.2.3) array_replace_recursive(['x' => ['A', 'B']], ['x' => 'C']) вернёт: ['x' => ['С', 'B']]
 *  https://php.net/manual/function.array-replace-recursive.php
 *  3.2.4) Наша функция ju_extend(['x' => ['A', 'B']], ['x' => 'C']) вернёт ['x' => 'C']
 *  2018-11-13
 *  1) ju_extend(
 *        ['TBCBank' => ['1111' => ['a' => 'b']]]
 *        ,['TBCBank' => ['2222' => ['c' => 'd']]]
 *  )
 *  is: 'TBCBank' => ['1111' => ['a' => 'b'], '2222' => ['c' => 'd']]
 *  2) ju_extend(
 *        ['TBCBank' => [1111 => ['a' => 'b']]]
 * 		,['TBCBank' => [2222 => ['c' => 'd']]]
 *  )
 *  is: 'TBCBank' => [1111 => ['a' => 'b'], 2222 => ['c' => 'd']]
 * 2020-06-26 "Port the `df_extend` function": https://github.com/justuno-com/core/issues/158
 * @used-by ju_extend()
 * @used-by ju_log()
 * @used-by ju_log_l()
 * @used-by ju_sentry()
 */
function ju_extend(array $defaults, array $newValues):array {/** @var array(string => mixed) $r */
	$r = $defaults;
	foreach ($newValues as $key => $newValue) {
		/** @var int|string $key */ /** @var mixed $newValue */ /** @var mixed $defaultValue */
		$defaultValue = jua($defaults, $key);
		if (!is_array($defaultValue)) {
			if (is_null($newValue)) {
				unset($r[$key]);
			}
			else {
				$r[$key] = $newValue;
			}
		}
		elseif (is_array($newValue)) {
			$r[$key] = ju_extend($defaultValue, $newValue);
		}
		elseif (is_null($newValue)) {
			unset($r[$key]);
		}
		else {
			ju_error(
				"ju_extend: the default value of key «{$key}» is an array {defaultValue},"
				. "\nbut the programmer mistakenly tries to substitute it"
				. ' with the value {newValue} of type «{newType}».'
				. "\nThe new value should be an array or `null`."
				,[
					'{defaultValue}' => ju_t()->singleLine(ju_dump($defaultValue))
					,'{newType}' => gettype($newValue)
					,'{newValue}' => ju_dump($newValue)
				]
			);
		}
	}
	return $r;
}

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
