<?php
/**
 * 2015-02-07
 * 2017-10-29 It returns `true` for an empty array.
 * 2020-06-18 "Port the `df_is_assoc` function": https://github.com/justuno-com/core/issues/62
 * @used-by ju_filter()
 * @param array(int|string => mixed) $a
 * @return bool
 */
function ju_is_assoc(array $a) {
	if (!($r = !$a)) { /** @var bool $r */
		foreach (array_keys($a) as $k => $v) {
			if ($k !== $v) {
				$r = true;
				break;
			}
		}
	}
	return $r;
}