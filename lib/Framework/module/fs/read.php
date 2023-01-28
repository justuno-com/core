<?php
use Closure as F;

/**
 * 2017-09-01
 * $m could be:
 * 		1) a module name: «A_B»
 * 		2) a class name: «A\B\C».
 * 		3) an object: it comes down to the case 2 via @see get_class()
 * 		4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2020-06-27 "Port the `df_module_file` function": https://github.com/justuno-com/core/issues/163
 * @used-by ju_module_json()
 * @used-by \Justuno\M2\W\Result\Js::i()
 * @param string|object|null $m
 * @param F|bool|mixed $onE [optional]
 * @return array(string => mixed)
 */
function ju_module_file_read($m, string $name, string $ext, F $parser, $onE = true):array {return jucf(
	function($m, string $name, string $ext, F $parser, $onE = true):array {
		$f = ju_module_file_name($m, $name, $ext, $onE);
		return !$f ? [] : $parser($f);
	}, func_get_args()
);}

/**
 * 2017-01-27
 * $m could be:
 * 		1) a module name: «A_B»
 * 		2) a class name: «A\B\C».
 * 		3) an object: it comes down to the case 2 via @see get_class()
 * 		4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 * 2020-06-27 "Port the `df_module_json` function": https://github.com/justuno-com/core/issues/162
 * @used-by ju_sentry_m()
 * @param F|bool|mixed $onE [optional]
 * @return array(string => mixed)
 */
function ju_module_json($m, string $name, $onE = true):array {return ju_module_file_read($m, $name, 'json',
	function(string $f):array {return ju_json_decode(file_get_contents($f));}, $onE
);}