<?php
/**
 * 2020-06-16
 * PHP supports global constants since 5.3:
 * http://www.codingforums.com/php/303927-unexpected-t_const-php-version-5-2-17-a.html#post1363452
 * @used-by ju_find()
 * @used-by ju_map()
 */
const JU_AFTER = 1;
/**
 * 2020-06-16
 * PHP supports global constants since 5.3:
 * http://www.codingforums.com/php/303927-unexpected-t_const-php-version-5-2-17-a.html#post1363452
 * @used-by ju_find()
 * @used-by ju_map()
 * @used-by ju_map_k()
 */
const JU_BEFORE = -1;

/**
 * 2015-02-11
 * 2020-06-18 "Port the `df_map` function": https://github.com/justuno-com/core/issues/60
 * @used-by ju_cache_clean()
 * @used-by ju_call_a()
 * @used-by ju_clean_r()
 * @used-by ju_int()
 * @used-by ju_map_k()
 * @used-by ju_map_kr()
 * @used-by ju_qty()
 * @used-by ju_trim()
 * @used-by \Justuno\Core\Qa\Trace::__construct()
 * @used-by \Justuno\M2\Controller\Response\Catalog::execute()
 * @used-by \Justuno\M2\Controller\Response\Inventory::execute()
 * @used-by \Justuno\M2\Inventory\Variants::p()
 * @param array|callable|Traversable $a1
 * @param array|callable|Traversable $a2
 * @param mixed|mixed[] $pAppend [optional]
 * @param mixed|mixed[] $pPrepend [optional]
 * @return array(int|string => mixed)
 */
function ju_map($a1, $a2, $pAppend = [], $pPrepend = [], int $keyPosition = 0, bool $returnKey = false):array {
	# 2020-03-02, 2022-10-31
	# 1) Symmetric array destructuring requires PHP ≥ 7.1:
	#		[$a, $b] = [1, 2];
	# https://github.com/mage2pro/core/issues/96#issuecomment-593392100
	# We should support PHP 7.0.
	# https://3v4l.org/3O92j
	# https://www.php.net/manual/migration71.new-features.php#migration71.new-features.symmetric-array-destructuring
	# https://stackoverflow.com/a/28233499
	list($a, $f) = juaf($a1, $a2); /** @var array|Traversable $a */ /** @var callable $f */
	/** @var array(int|string => mixed) $r */
	if (!$pAppend && !$pPrepend && 0 === $keyPosition && !$returnKey) {
		$r = array_map($f, ju_ita($a));
	}
	else {
		$pAppend = ju_array($pAppend); $pPrepend = ju_array($pPrepend);
		$r = [];
		foreach ($a as $k => $v) {/** @var int|string $k */ /** @var mixed $v */ /** @var mixed[] $primaryArgument */
			switch ($keyPosition) {
				case JU_BEFORE:
					$primaryArgument = [$k, $v];
					break;
				case JU_AFTER:
					$primaryArgument = [$v, $k];
					break;
				default:
					$primaryArgument = [$v];
			}
			$fr = call_user_func_array($f, array_merge($pPrepend, $primaryArgument, $pAppend)); /** @var mixed $fr */
			if (!$returnKey) {
				$r[$k] = $fr;
			}
			else {
				$r[$fr[0]] = $fr[1]; # 2016-10-25 It allows to return custom keys.
			}
		}
	}
	return $r;
}

/**
 * 2016-08-09
 * 2020-06-18 "Port the `df_map_k` function": https://github.com/justuno-com/core/issues/70
 * @used-by ju_file_name()
 * @used-by ju_ksort_r()
 * @used-by ju_kv()
 * @used-by \Justuno\Core\Html\Tag::openTagWithAttributesAsText()
 * @used-by \Justuno\Core\Qa\Dumper::dumpArrayElements()
 * @used-by \Justuno\Core\Qa\Trace\Formatter::p()
 * @used-by \Justuno\Core\Sentry\Client::send()
 * @used-by \Justuno\Core\Sentry\Client::send_http()
 * @param array|callable|Traversable $a1
 * @param array|callable|Traversable $a2
 * @return array(int|string => mixed)
 */
function ju_map_k($a1, $a2):array {return ju_map($a1, $a2, [], [], JU_BEFORE);}

/**
 * 2016-11-08
 * 2020-08-13 "Port the `df_map_kr` function" https://github.com/justuno-com/core/issues/167
 * @used-by juak_transform()
 * @used-by \Justuno\M2\Catalog\Images::p()
 * @used-by \Justuno\M2\Catalog\Variants::variant()
 * @param array|callable|Traversable $a1
 * @param array|callable|Traversable $a2
 * @return array(int|string => mixed)
 */
function ju_map_kr($a1, $a2):array {return ju_map($a1, $a2, [], [], JU_BEFORE, true);}