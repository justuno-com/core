<?php
/** 2022-10-17 @see array_is_list() has been added to PHP 8.1: https://www.php.net/manual/function.array-is-list.php **/
if (!function_exists('array_is_list')) {
	/**
	 * 2015-02-07
	 * 2017-10-29 It returns `true` for an empty array.
	 * @used-by ju_ksort_r_ci()
	 * @used-by ju_sort()
	 * @used-by juak_transform()
	 * @param array(int|string => mixed) $a
	 */
	function array_is_list(array $a):bool {
		$r = true; /** @var bool $r */
		foreach (array_keys($a) as $k => $v) {
			if ($k !== $v) {
				$r = false;
				break;
			}
		}
		return $r;
	}
}

/**
 * 2015-02-07
 * 2017-10-29 It returns `true` for an empty array.
 * 2020-06-18 "Port the `df_is_assoc` function": https://github.com/justuno-com/core/issues/62
 * 2022-10-17 @uses array_is_list() has been added to PHP 8.1: https://www.php.net/manual/function.array-is-list.php
 * @used-by ju_filter_f()
 * @used-by ju_ksort()
 * @param array(int|string => mixed) $a
 */
function ju_is_assoc(array $a):bool {return !$a || !array_is_list($a);}

/**
 * 2023-07-25
 * @uses is_object()
 * @used-by \Justuno\Core\Qa\Dumper::dumpArray()
 * @param iterable $a
 */
function jua_has_objects($a):bool {return !!ju_find($a, 'is_object', [], [], 0, true);}