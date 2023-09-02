<?php
use Justuno\Core\Exception as DFE;
use Justuno\Core\Qa\Method as Q;
use Throwable as Th; # 2023-08-31 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401

/**
 * 2019-12-14
 * If you do not want the exception to be logged via @see df_bt(),
 * then you can pass an empty string (instead of `null`) as the second argument:
 * @see \Justuno\Core\Exception::__construct():
 *		if (is_null($m)) {
 *			$m = __($prev ? ju_xts($prev) : 'No message');
 *			# 2017-02-20 To facilite the «No message» diagnostics.
 *			if (!$prev) {
 *				ju_bt_log();
 *			}
 *		}
 * https://github.com/mage2pro/core/blob/5.5.7/Core/Exception.php#L61-L67
 * 2020-06-17 "Port the `df_assert` function": https://github.com/justuno-com/core/issues/33
 * @used-by ju_assert_qty_supported()
 * @used-by ju_catalog_locator()
 * @used-by ju_eta()
 * @used-by ju_layout_update()
 * @used-by ju_module_dir()
 * @used-by ju_module_file_name()
 * @used-by ju_oqi_amount()
 * @used-by juaf()
 * @used-by \Justuno\Core\Html\Tag::openTagWithAttributesAsText()
 * @used-by \Justuno\Core\Qa\Trace\Frame::methodParameter()
 * @used-by \Justuno\Core\Qa\Trace\Frame::url()
 * @used-by \Justuno\M2\Store::v()
 * @param mixed $cond
 * @param string|Th|null $m [optional]
 * @return mixed
 * @throws DFE
 */
function ju_assert($cond, $m = null) {return $cond ?: ju_error($m);}

/**
 * 2020-06-22 "Port the `df_assert_sne` function": https://github.com/justuno-com/core/issues/115
 * @used-by ju_currency_base()
 * @used-by ju_file_name()
 * @throws DFE
 */
function ju_assert_sne(string $v, int $sl = 0):string {
	$sl++;
	# The previous code `if (!$v)` was wrong because it rejected the '0' string.
	return !ju_es($v) ? $v : Q::raiseErrorVariable(__FUNCTION__, [Q::NES], $sl);
}

/**
 * 2016-08-09
 * 2020-08-21 "Port the `ju_assert_traversable` function" https://github.com/justuno-com/core/issues/222
 * @used-by juaf()
 * @param Traversable|array $v
 * @param string|Th|null $m [optional]
 * @return Traversable|array
 * @throws DFE
 */
function ju_assert_traversable($v, $m = null) {return is_iterable($v) ? $v : ju_error($m ?:
	'A variable is expected to be a Traversable or an array, ' . 'but actually it is %s.', ju_type($v)
);}