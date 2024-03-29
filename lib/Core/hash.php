<?php
use Magento\Framework\Model\AbstractModel as M;
/**
 * 2020-06-13 "Port the `df_hash_a` function": https://github.com/justuno-com/core/issues/6
 * @used-by ju_hash_a()
 * @used-by juc()
 * @used-by jucf()
 * @param mixed[] $a
 */
function ju_hash_a(array $a):string {
	$resultA = []; /** @var string[] $resultA */
	foreach ($a as $k => $v) {/** @var int|string $k */ /** @var mixed $v */
		$resultA[]= "$k=>" . (is_object($v) ? ju_hash_o($v) : (is_array($v) ? ju_hash_a($v) : $v));
	}
	return implode('::', $resultA);
}

/**
 * 2020-06-13 "Port the `df_hash_o` function": https://github.com/justuno-com/core/issues/7
 * 2022-12-02
 * `object` as an argument type is not supported by PHP < 7.2: https://github.com/mage2pro/core/issues/174#user-content-object
 * @used-by ju_hash_a()
 * @param object $o
 */
function ju_hash_o($o):string {
	/** 2016-09-05 Для ускорения заменил вызов df_id($o, true) на инлайновыый код. @see df_id() */
	$r = $o instanceof M || method_exists($o, 'getId') ? $o->getId() : null; /** @var string $r */
	return $r ? get_class($o) . "::$r" : spl_object_hash($o);
}