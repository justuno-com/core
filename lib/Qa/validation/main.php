<?php
use Df\Core\Exception as DFE;
use Exception as E;

/**
 * 2019-12-14
 * If you do not want the exception to be logged via @see df_bt(),
 * then you can pass an empty string (instead of `null`) as the second argument:
 * @see \Df\Core\Exception::__construct():
 *		if (is_null($m)) {
 *			$m = __($prev ? df_ets($prev) : 'No message');
 *			// 2017-02-20 To facilite the «No message» diagnostics.
 *			if (!$prev) {
 *				df_bt();
 *			}
 *		}
 * https://github.com/mage2pro/core/blob/5.5.7/Core/Exception.php#L61-L67
 * 2020-06-17 "Port the `df_assert` function": https://github.com/justuno-com/core/issues/33
 * @used-by juaf()
 * @param mixed $cond
 * @param string|E|null $m [optional]
 * @return mixed
 * @throws DFE
 */
function ju_assert($cond, $m = null) {return $cond ?: ju_error($m);}