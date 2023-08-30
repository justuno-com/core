<?php
namespace Justuno\Core;
# 2023-08-30
final class Json {
	/**
	 * 023-08-30 "Implement `ju_json_dont_sort()`": https://github.com/justuno-com/core/issues/402
	 * @used-by ju_json_dont_sort()
	 * @used-by ju_json_sort()
	 * @param bool|null|string $v [optional]
	 * @return self|bool
	 */
	static function bSort($v = JU_N) {return ju_prop(null, $v, true);}
}