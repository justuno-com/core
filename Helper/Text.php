<?php
namespace Justuno\Core\Helper;
# 2020-06-26 "Port the `Df\Core\Helper\Text` class": https://github.com/justuno-com/core/issues/160
class Text {
	/**
	 * @used-by ju_quote_russian()
	 * @param string|string[]|array(string => string) $s
	 * @return string|string[]
	 */
	function quote($s, string $t = self::QUOTE__RUSSIAN) {
		static $m = [self::QUOTE__RUSSIAN => ['«', '»']]; /** @var array(string => string[]) $m */
		$quotes = jua($m, $t); /** @var string[] $quotes */
		if (!is_array($quotes)) {
			ju_error("An unknown quote: «{$t}».");
		}
		# 2016-11-13 It injects the value $s inside quotes.
		$f = function(string $s) use($quotes):string {return implode($s, $quotes);};
		return !is_array($s) ? $f($s) : array_map($f, $s);
	}

	/**
	 * 2015-03-03
	 * @used-by ju_extend()
	 */
	function singleLine(string $s):string {return str_replace(["\r\n", "\r", "\n", "\t"], ' ', $s);}

	/**
	 * @used-by ju_quote_russian()
	 * @used-by self::quote()
	 */
	const QUOTE__RUSSIAN = 'russian';

	/**
	 * @used-by ju_t()
	 * @return self
	 */
	static function s() {static $r; return $r ? $r : $r = new self;}
}