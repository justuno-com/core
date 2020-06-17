<?php
/**
 * 2015-02-07
 * 2020-06-18 "Port the `df_clean` function": https://github.com/justuno-com/core/issues/58
 * @used-by ju_ccc()
 * @param mixed[] $r
 * @param mixed ...$k [optional]
 * @return mixed[]
 */
function ju_clean(array $r, ...$k) {/** @var mixed[] $r */return df_clean_r(
	$r, array_merge([false], ju_args($k)), false
);}