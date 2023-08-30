<?php
/**
 * 2020-06-16 "Port the `df_find` function": https://github.com/justuno-com/core/issues/31
 * 2022-11-26
 * @see array_search() looks only for a static value (does not support a comparison closure):
 * https://php.net/manual/function.array-search.php
 * 2023-07-26
 * 1) "Replace `array|Traversable` with `iterable`": https://github.com/mage2pro/core/issues/255
 * 2) https://php.net/manual/language.types.iterable.php
 * https://php.net/manual/en/migration82.other-changes.php#migration82.other-changes.core
 * 3) Using `iterable` as an argument type requires PHP ≥ 7.1: https://3v4l.org/SNUMI
 * @used-by ju_ends_with()
 * @used-by ju_find()
 * @used-by ju_starts_with()
 * @used-by jua_has_objects()
 * @param iterable|callable $a1
 * @param iterable|callable $a2
 * @param mixed|mixed[] $pAppend [optional]
 * @param mixed|mixed[] $pPrepend [optional]
 */
function ju_find($a1, $a2, $pAppend = [], $pPrepend = [], int $keyPosition = 0, bool $nested = false) {
	# 2020-03-02, 2022-10-31
	# 1) Symmetric array destructuring requires PHP ≥ 7.1:
	#		[$a, $b] = [1, 2];
	# https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	# We should support PHP 7.0.
	# https://3v4l.org/3O92j
	# https://php.net/manual/migration71.new-features.php#migration71.new-features.symmetric-array-destructuring
	# https://stackoverflow.com/a/28233499
	list($a, $f) = juaf($a1, $a2); /** @var iterable $a */ /** @var callable $f */
	$pAppend = ju_array($pAppend); $pPrepend = ju_array($pPrepend);
	$r = null; /** @var mixed|null $r */
	foreach ($a as $k => $v) {/** @var int|string $k */ /** @var mixed $v */ /** @var mixed[] $primaryArgument */
		switch ($keyPosition) {
			case JU_BEFORE:
				$primaryArgument = [$k, $v];
				break;
			case JU_AFTER:
				$primaryArgument = [$v, $k];
				break;
			default:
				$primaryArgument = [$v];
		}
		if ($fr = call_user_func_array($f, array_merge($pPrepend, $primaryArgument, $pAppend))) {
			$r = !is_bool($fr) ? $fr : $v;
			break;
		}
	}
	# 2023-07-25
	# 1) "Adapt `df_find` to the nested search": https://github.com/mage2pro/core/issues/251
	# 2) I implement the nested seach in a separate loop to minimize recursions.
	if (null === $r && $nested) {
		foreach ($a as $v) {/** @var int|string $k */ /** @var mixed $v */ /** @var mixed[] $primaryArgument */
			if (is_iterable($v)) {
				if ($r = ju_find($v, $f, $pAppend, $pPrepend, $keyPosition, true)) {
					break;
				}
			}
		}
	}
	return $r;
}