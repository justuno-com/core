<?php
namespace Justuno\Core;
# 2020-06-13 "Port the `Df\Core\RAM` class": https://github.com/justuno-com/core/issues/9
final class RAM {
	/**
	 * 2020-06-13
	 * The following code will return `1`:
	 * 		$a = ['a' => null];
	 * 		echo intval(array_key_exists('a', $a));
	 * https://3v4l.org/9cQOO
	 * @used-by jucf()
	 * @used-by get()
	 */
	function exists(string $k):bool {return array_key_exists($k, $this->_data);}

	/**
	 * 2020-06-13
	 * @used-by jucf()
	 * @return mixed
	 */
	function get(string $k) {return $this->exists($k) ? $this->_data[$k] : null;}

	/**
	 * 2020-06-13
	 */
	function reset() {$this->_data = []; $this->_tags = [];}

	/**
	 * 2020-06-13
	 * @used-by jucf()
	 * @param string $k
	 * @param mixed $v
	 * @param string[] $tags [optional]
	 * @return mixed
	 */
	function set($k, $v, $tags = []) {
		if ($v instanceof ICached) {
			$tags += $v->tags();
		}
		$this->_data[$k] = $v;
		foreach ($tags as $tag) { /** @var string $tag */
			if (!isset($this->_tags[$tag])) {
				$this->_tags[$tag] = [$k];
			}
			elseif (!in_array($k, $this->_tags[$tag])) {
				$this->_tags[$tag][] = $k;
			}
		}
		return $v;
	}

	/**
	 * 2017-08-10
	 * @used-by self::exists()
	 * @used-by self::get()
	 * @used-by self::set()
	 * @var array(string => mixed)	«Cache Key => Cached Data»
	 */
	private $_data = [];

	/**
	 * 2017-08-10
	 * @used-by self::set()
	 * @var array(string => string[])  «Tag ID => Cache Keys»
	 */
	private $_tags = [];

	/** 2017-08-10 @return self */
	static function s() {static $r; return $r ? $r : $r = new self;}
}