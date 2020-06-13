<?php
/**
 * 2020-06-13 "Port the `df_hash_a` function": https://github.com/justuno-com/core/issues/6
 * @used-by ju_hash_a()
 * @used-by jucf() 
 * @param mixed[] $a
 * @return string
 */
function ju_hash_a(array $a) {
	$resultA = []; /** @var string[] $resultA */
	foreach ($a as $k => $v) {
		/** @var int|string $k */ /** @var mixed $v */
		$resultA[]= "$k=>" . (is_object($v) ? df_hash_o($v) : (is_array($v) ? ju_hash_a($v) : $v));
	}
	return implode('::', $resultA);
}