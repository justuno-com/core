<?php
namespace Justuno\Core\Qa;
# 2020-06-18 "Port the `Df\Qa\Dumper` class": https://github.com/justuno-com/core/issues/82
/** 2023-07-25 @todo Use YAML instead of JSON for `df_dump()` https://github.com/mage2pro/core/issues/254 */
final class Dumper {
	/**
	 * @used-by ju_dump()
	 * @used-by self::dumpArrayElements()
	 * @param mixed $v
	 */
	function dump($v):string {return is_object($v) ? $this->dumpObject($v) : (
		is_array($v) ? $this->dumpArray($v) : (is_bool($v) ? ju_bts($v) : (is_string($v) ? $v : print_r($v, true)))
	);}

	/** @used-by self::dump() */
	private function dumpArray(array $a):string {return
        # 2023-07-25
        # "Return JSON from `\Df\Qa\Dumper::dumpArray()` for arrays without object elements":
        # https://github.com/mage2pro/core/issues/252
        !jua_has_objects($a) ? ju_json_encode($a) : "[\n" . ju_tab_multiline($this->dumpArrayElements($a)) . "\n]"
    ;}

	/**
	 * 2015-01-25
	 * @see ju_kv()
	 * @used-by self::dumpArray()
	 * @used-by self::dumpObject()
	 * @param mixed[]|array(string => mixed) $a
	 */
	function dumpArrayElements(array $a):string {return ju_cc_n(ju_map_k(ju_ksort($a), function($k, $v) {return
		"$k: {$this->dump($v)}"
	;}));}

	/**
	 * 2022-11-17
	 * `object` as an argument type is not supported by PHP < 7.2:
	 * https://github.com/mage2pro/core/issues/174#user-content-object
	 * @used-by self::dump()
	 * @param object $o
	 */
	private function dumpObject($o):string {/** @var string $r */
		$hash = spl_object_hash($o); /** @var string $hash */
		if (isset($this->_dumped[$hash])) {
			$r = sprintf('[recursion: %s]', get_class($o));
		}
		else {
			$this->_dumped[$hash] = true;
			$r = !ju_has_gd($o)
				? sprintf("%s %s", get_class($o), ju_json_encode_partial($o))
				: sprintf("%s(%s\n)", get_class($o), ju_tab_multiline($this->dumpArrayElements($o->getData())))
			;
		}
		return $r;
	}

	/**
	 * @used-by self::dumpObject()
	 * @var array(string => bool)
	 */
	private $_dumped = [];

	/**
	 * Обратите внимание, что мы намеренно не используем для этого класса объект-одиночку,
	 * потому что нам надо вести учёт выгруженных объектов,
	 * чтобы не попасть в бесконечную рекурсию при циклических ссылках.
	 */
	static function i():self {return new self;}
}