<?php
/**
 * 2017-02-01
 * 2020-01-29
 * 2020-02-04
 * It does not change keys of a non-associative array,
 * but it is applied recursively to nested arrays, so it could change keys their keys.
 * 2020-08-13 "Port the `dfak_transform` function" https://github.com/justuno-com/core/issues/166
 * @used-by juak_transform()
 * @used-by \Justuno\Core\Sentry\Client::tags()
 * @used-by \Justuno\Core\Sentry\Extra::adjust()
 * @param array|callable|Traversable $a1
 * @param array|callable|Traversable $a2
 * @return array(string => mixed)
 */
function juak_transform($a1, $a2, bool $req = false):array {
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
	$l = array_is_list($a); /** @var bool $l */
	return ju_map_kr($a, function($k, $v) use($f, $req, $l) {return [
		$l ? $k : $f($k), !$req || !is_array($v) ? $v : juak_transform($v, $f, $req)
	];});
}