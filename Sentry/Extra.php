<?php
# 2017-01-03
# https://forum.sentry.io/t/694
# https://docs.sentry.io/learn/quotas/#attributes-limits
# 2020-08-13 "Port the `Df\Sentry\Extra` class" https://github.com/justuno-com/core/issues/172
namespace Justuno\Core\Sentry;
final class Extra {
	/**
	 * 2017-01-03
	 * @used-by self::adjust() Recursion.
	 * @used-by \Justuno\Core\Sentry\Client::capture()
	 * @param array(string => mixed) $a
	 * @return array(string => string)
	 */
	static function adjust(array $a):array {/** @var array(string => string) $r */
		$r = [];
		foreach ($a as $k => $v)  {/** @var string $k */ /** @var mixed $v */
			$vs = ju_dump($v); /** @var string $vs */
			/** @var iterable|null $vi */
			if (self::fits($vs) || is_null($vi = is_iterable($v) ? $v : (ju_has_gd($v) ? ju_gd($v) : null))) {
				$r[$k] = $vs;
			}
			else {
				# 2017-01-03 I split the array among miltiple Sentry fields.
				$r = array_merge($r, self::adjust(juak_transform($vi, function($vk) use($k) {return "$k/$vk";})));
			}
		}
		return $r;
	}

	/**
	 * 2023-07-30
	 * 2017-01-03 We need the length in bytes, not in characters: https://docs.sentry.io/learn/quotas/#attributes-limits
	 * 2023-07-29
	 * 1) In 2016, the limit was 512 bytes.
	 * "How to disable data clipping in the «Additional Data» block?": https://forum.sentry.io/t/694
	 * 2) Today I noticed that Sentry accepts up to 16400 bytes per a field.
	 * @used-by self::adjust()
	 * @used-by \Justuno\Core\Sentry\Client::capture()
	 */
	static function fits(string $s):bool {return 16400 >= strlen($s);}
}