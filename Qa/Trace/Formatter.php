<?php
namespace Justuno\Core\Qa\Trace;
use Justuno\Core\Qa\Trace as T;
use Justuno\Core\Qa\Trace\Frame as F;
# 2020-02-27
# 2020-08-19 "Port the `Df\Qa\Trace\Formatter` class" https://github.com/justuno-com/core/issues/196
final class Formatter {
	/**
	 * 2020-02-27
	 * @used-by ju_bt_s()
	 * @used-by \Justuno\Core\Qa\Failure::postface()
	 */
	static function p(T $t):string {return jucf(function(T $t):string {return ju_try(
		function() use($t) {return ju_cc("\n\n", ju_map_k($t, function(int $i, F $f):string {$i++; return ju_ccc("\n\t", [
			"$i\t" . $f->method()
			# 2023-07-27 "Add GitHub links to backtrace frames": https://github.com/mage2pro/core/issues/285
			,$f->url() ?: ju_ccc(':', $f->file(), $f->line())
		]);}));}
		# 2023-08-31 "Treat `\Throwable` similar to `\Exception`": https://github.com/justuno-com/core/issues/401
		,function(\Throwable $th) {
			$r = ju_xts($th);
			/**
			 * 2020-02-20
			 * 1) «Function include() does not exist»: https://github.com/tradefurniturecompany/site/issues/60
			 * 2) It is be dangerous to call @see df_log() here, because it will inderectly return us here,
			 * and it could be an infinite loop.
			 */
			static $loop = false;
			if ($loop) {
				ju_log_l(__CLASS__, "$r\n{$th->getTraceAsString()}", ju_class_l(__CLASS__));
			}
			else {
				$loop = true;
				ju_log($th, __CLASS__);
				$loop = false;
			}
		}
	);}, [$t]);}
}