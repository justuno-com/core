<?php
/**
 * 2015-02-07
 * 2020-06-18 "Port the `df_clean` function": https://github.com/justuno-com/core/issues/58
 * @used-by ju_ccc()
 * @param mixed[] $r
 * @param mixed ...$k [optional]
 * @return mixed[]
 */
function ju_clean(array $r, ...$k) {/** @var mixed[] $r */return ju_clean_r(
	$r, array_merge([false], ju_args($k)), false
);}

/**
 * 2020-02-05
 * 2020-06-18 "Port the `df_clean_r` function": https://github.com/justuno-com/core/issues/59
 * @see df_clean()
 * 1) It works recursively.
 * 2) I does not remove `false`.
 * @used-by ju_clean()
 * @used-by ju_clean_r()
 * @param mixed[] $r
 * @param mixed[] $k
 * @param bool $req [optional]
 * @return mixed[]
 */
function ju_clean_r(array $r, $k = [], $req = true) {/** @var mixed[] $r */
	/** 2020-02-05 @see array_unique() does not work correctly here, even with the @see SORT_REGULAR flag. */
	$k = array_merge($k, ['', null, []]);
	if ($req) {
		$r = df_map($r, function($v) use($k) {return !is_array($v) ? $v : ju_clean_r($v, $k);});
	}
	return df_filter($r, function($v) use($k) {return !in_array($v, $k, true);});
}