<?php
namespace Justuno\Core\Helper;
# 2020-06-26 "Port the `Df\Core\Helper\Text` class": https://github.com/justuno-com/core/issues/160
class Text {
	/**
	 * 2015-03-03
	 * @used-by ju_extend()
	 * @param string $s
	 * @return string
	 */
	function singleLine($s) {return str_replace(["\r\n", "\r", "\n", "\t"], ' ', $s);}

	/**
	 * @used-by ju_t()
	 * @return self
	 */
	static function s() {static $r; return $r ? $r : $r = new self;}
}