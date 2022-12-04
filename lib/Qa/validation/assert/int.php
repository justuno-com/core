<?php
use Justuno\Core\Exception as DFE;
use Justuno\Core\Zf\Validate\StringT\IntT;
/**
 * 2020-08-23 "Port the `ju_int` function" https://github.com/justuno-com/core/issues/287
 * @used-by ju_nat()
 * @used-by ju_product_id()
 * @used-by \Justuno\Core\Zf\Validate\IntT::filter()
 * @param mixed|mixed[] $v
 * @return int|int[]
 * @throws DFE
 */
function ju_int($v, bool $allowNull = true) {/** @var int|int[] $r */
	if (is_array($v)) {
		$r = ju_map(__FUNCTION__, $v, $allowNull);
	}
	elseif (is_int($v)) {
		$r = $v;
	}
	elseif (is_bool($v)) {
		$r = $v ? 1 : 0;
	}
	elseif ($allowNull && ju_nes($v)) {
		$r = 0;
	}
	elseif (!IntT::s()->isValid($v)) {
		ju_error(IntT::s()->message());
	}
	else {
		$r = (int)$v;
	}
	return $r;
}

/**
 * 2015-04-13
 * 1) It does not validate item types (unlike @see ju_int() )
 * 2) It works only with arrays.
 * 3) Keys are preserved: http://3v4l.org/NHgdK
 * @used-by ju_fetch_col_int()
 * @param mixed[] $values
 * @return int[]
 */
function ju_int_simple(array $values):array {return array_map('intval', $values);}

/**
 * 2020-08-23 "Port the `df_nat` function" https://github.com/justuno-com/core/issues/289
 * @used-by \Justuno\M2\Controller\Cart\Add::execute()
 * @used-by \Justuno\M2\Controller\Cart\Add::product()
 * @param mixed $v
 * @throws DFE
 */
function ju_nat($v, bool $allow0 = false):int {/** @var int $r */
	$r = ju_int($v, $allow0);
	$allow0 ? ju_assert_ge(0, $r) : ju_assert_gt0($r);
	return $r;
}