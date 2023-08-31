<?php
/**
 * 2015-02-07
 * 2020-06-18 "Port the `df_clean` function": https://github.com/justuno-com/core/issues/58
 * @see ju_clean_null()
 * @see ju_clean_r()
 * @used-by ju_ccc()
 * @used-by ju_context()
 * @used-by ju_kv()
 * @used-by \Justuno\Core\Sentry\Client::capture()
 * @used-by \Justuno\Core\Sentry\Client::send()
 * @used-by \Justuno\M2\Block\Js::_toHtml()
 * @param mixed ...$k [optional]
 */
function ju_clean(array $r, ...$k):array {/** @var mixed[] $r */return ju_clean_r(
	$r, array_merge([false], ju_args($k)), false
);}

/**
 * 2023-07-20
 * @see ju_clean()
 * @see ju_clean_r()
 * @used-by jua_select_ordered()
 */
function ju_clean_null(array $r):array {return array_filter($r, function($v) {return !is_null($v);});}

/**
 * 2020-02-05
 * 2020-06-18 "Port the `df_clean_r` function": https://github.com/justuno-com/core/issues/59
 * @see ju_clean()
 * @see ju_clean_null()
 * 1) It works recursively.
 * 2) I does not remove `false`.
 * @used-by ju_clean()
 * @used-by ju_clean_r()
 * @used-by \Justuno\Core\Html\Tag::__construct()
 */
function ju_clean_r(array $r, array $k = [], bool $req = true):array {/** @var mixed[] $r */
	/** 2020-02-05 @see array_unique() does not work correctly here, even with the @see SORT_REGULAR flag. */
	$k = array_merge($k, ['', null, []]);
	if ($req) {
		$r = ju_map($r, function($v) use($k) {return !is_array($v) ? $v : ju_clean_r($v, $k);});
	}
	return ju_filter($r, function($v) use($k):bool {return !in_array($v, $k, true);});
}