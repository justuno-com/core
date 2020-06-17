<?php
use Justuno\Core\Exception as DFE;

/**
 * 2020-06-16
 * PHP supports global constants since 5.3:
 * http://www.codingforums.com/php/303927-unexpected-t_const-php-version-5-2-17-a.html#post1363452
 * @used-by ju_find()
 * @used-by ju_map()
 */
const JU_AFTER = 1;
/**
 * 2020-06-16
 * PHP supports global constants since 5.3:
 * http://www.codingforums.com/php/303927-unexpected-t_const-php-version-5-2-17-a.html#post1363452
 * @used-by ju_find()
 * @used-by ju_map()
 */
const JU_BEFORE = -1;

/**
 * 2015-02-11
 * 2020-06-18 "Port the `df_map` function": https://github.com/justuno-com/core/issues/60
 * @used-by ju_clean_r()
 * @param array|callable|\Traversable $a1
 * @param array|callable|\Traversable $a2
 * @param mixed|mixed[] $pAppend [optional]
 * @param mixed|mixed[] $pPrepend [optional]
 * @param int $keyPosition [optional]
 * @param bool $returnKey [optional]
 * @return array(int|string => mixed)
 * @throws DFE
 */
function ju_map($a1, $a2, $pAppend = [], $pPrepend = [], $keyPosition = 0, $returnKey = false) {
	// 2020-03-02
	// The square bracket syntax for array destructuring assignment (`[…] = […]`) requires PHP ≥ 7.1:
	// https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	// We should support PHP 7.0.
	[$a, $f] = juaf($a1, $a2); /** @var array|\Traversable $a */ /** @var callable $f */
	/** @var array(int|string => mixed) $r */
	if (!$pAppend && !$pPrepend && 0 === $keyPosition && !$returnKey) {
		$r = array_map($f, ju_ita($a));
	}
	else {
		$pAppend = ju_array($pAppend); $pPrepend = ju_array($pPrepend);
		$r = [];
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
			$fr = call_user_func_array($f, array_merge($pPrepend, $primaryArgument, $pAppend)); /** @var mixed $fr */
			if (!$returnKey) {
				$r[$k] = $fr;
			}
			else {
				$r[$fr[0]] = $fr[1]; // 2016-10-25 It allows to return custom keys.
			}
		}
	}
	return $r;
}