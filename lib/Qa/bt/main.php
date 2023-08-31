<?php
use Throwable as Th; # 2023-08-30 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401

/**
 * 2021-10-04
 * 2023-07-27  The first entry in the result is the caller of df_bt().
 * @used-by ju_bt_has()
 * @used-by ju_bt_s()
 * @used-by ju_caller_entry()
 * @used-by \Justuno\Core\Qa\Method::caller()
 * @param Th|int|null|array(array(string => string|int)) $p [optional]
 * @return array(array(string => mixed))
 */
function ju_bt($p = 0, int $limit = 0):array {
	$r = is_array($p) ? $p : (ju_is_th($p) ? ju_bt_th($p) :
		debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, !$limit ? 0 : 1 + $p + $limit)
	);
	# 2023-07-27 "Shift the `file` and `line` keys to an entry back in `df_bt()`": https://github.com/mage2pro/core/issues/283
	list($f, $l) = ['', 0]; /** @var string $f */ /** @var int $l */
	foreach ($r as &$e) {/** @var array(string => int|string) $e */
		list($f2, $l2) = [ju_bt_entry_file($e), ju_bt_entry_line($e)]; /** @var string $f2 */ /** @var int $l2 */
		$e = ['file' => $f, 'line' => $l] + $e;
		list($f, $l) = [$f2, $l2];
	}
	/**
	 * 2023-07-28 We skip the first entry: `df_bt`.
	 * 2023-08-25
	 * For the @see \Throwable case we do not need to skip df_bt() (because it is absent in the trace),
	 * but we still need to skip the first frame because it is empty after we shifted the `file` and `line` keys (see above).
	 * The first frame was artificial: @see df_bt_th()
	 */
	$r = ju_slice($r, 1);
	return is_array($p) || ju_is_th($p) ? $r : ju_slice($r, $p, $limit);
}

/**
 * 2020-05-25
 * @used-by \Justuno\Core\Framework\Log\Handler\NoSuchEntity::_p()
 */
function ju_bt_has(string $c, string $m = '', Th $t = null):bool {
	list($c, $m) = $m ? [$c, $m] : explode('::', $c);
	return !!ju_find(function(array $i) use($c, $m) {return $c === jua($i, 'class') && $m === jua($i, 'function');}, ju_bt($t));
}

/**
 * 2021-10-04
 * @used-by ju_bt_log()
 * @used-by ju_bt_s()
 * @used-by ju_caller_entry()
 * @used-by ju_caller_module()
 * @param Th|int|null|array(array(string => string|int)) $p
 * @return Th|int
 */
function ju_bt_inc($p, int $o = 1) {return is_array($p) || ju_is_th($p) ? $p : $o + $p;}