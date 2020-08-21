<?php
use Df\Core\Exception as DFE;
/**
 * 2020-06-14 "Port the `dfa_deep` function": https://github.com/justuno-com/core/issues/18
 * @used-by jua()
 * @used-by \Justuno\Core\O::offsetExists()
 * @param array(string => mixed) $a
 * @param string|string[]|null $path
 * @param mixed $d [optional]
 * @return mixed|null
 * @throws DFE
 */
function jua_deep(array $a, $path, $d = null) {/** @var mixed|null $r */
	if (ju_nes($path)) {
		$r = $a;
	}
	else if (is_array($path)) {
		$pathParts = $path;
	}
	else {
		ju_param_sne($path, 1);
		if (isset($a[$path])) {
			$r = $a[$path];
		}
		else {
			$pathParts = ju_explode_xpath($path); /** @var string[] $pathParts */
		}
	}
	if (!isset($r)) {
		$r = null;
		/** @noinspection PhpUndefinedVariableInspection */
		while ($pathParts) {
			$r = jua($a, array_shift($pathParts));
			if (is_array($r)) {
				$a = $r;
			}
			else {
				if ($pathParts) {
					$r = null;
				}
				break;
			}
		}
	}
	return is_null($r) ? $d : $r;
}

