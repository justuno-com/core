<?php
/**
 * 2016-03-25 «charge.dispute.funds_reinstated» => [charge, dispute, funds, reinstated]
 * 2020-06-26 "Port the `df_explode_multiple` function": https://github.com/justuno-com/core/issues/140
 * @used-by ju_explode_class()
 * @param string[] $delimiters
 * @param string $s
 * @return string[]
 */
function ju_explode_multiple(array $delimiters, $s) {
	$main = array_shift($delimiters); /** @var string $main */
	/**
	 * 2016-03-25
	 * «If search is an array and replace is a string,
	 * then this replacement string is used for every value of search.»
	 * http://php.net/manual/function.str-replace.php
	 */
	return explode($main, str_replace($delimiters, $main, $s));
}

/**
 * 2018-04-24 I have added @uses trim() today.
 * 2020-06-20 "Port the `df_explode_n` function": https://github.com/justuno-com/core/issues/86
 * @used-by ju_tab_multiline()
 * @param string $s
 * @return string[]
 */
function ju_explode_n($s) {return explode("\n", ju_normalize(ju_trim($s)));}

/**
 * 2020-06-14 "Port the `df_explode_xpath` function": https://github.com/justuno-com/core/issues/20
 * @used-by jua_deep()
 * @param string|string[] $p
 * @return string[]
 */
function ju_explode_xpath($p) {return jua_flatten(array_map(function($s) {return explode('/', $s);}, ju_array($p)));}