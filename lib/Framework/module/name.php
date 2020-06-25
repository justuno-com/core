<?php
/**
 * «Dfe\AllPay\W\Handler» => «Dfe_AllPay»
 *
 * 2016-10-26
 * The function correctly handles class names without a namespace and with the `_` character:
 * «A\B\C» => «A_B»
 * «A_B» => «A_B»
 * «A» => A»
 * https://3v4l.org/Jstvc
 *
 * 2017-01-27
 * $c could be:
 * 1) a module name: «A_B»
 * 2) a class name: «A\B\C».
 * 3) an object: it comes down to the case 2 via @see get_class()
 * 4) `null`: it comes down to the case 1 with the «Justuno_Core» module name.
 *
 * 2020-06-26 "Port the `ju_module_name` function": https://github.com/justuno-com/core/issues/138
 *
 * @used-by ju_package()
 * @used-by ju_sentry_module()
 * @param string|object|null $c [optional]
 * @param string $del [optional]
 * @return string
 */
function ju_module_name($c = null, $del = '_') {return jucf(function($c, $del) {return implode($del, array_slice(
	ju_explode_class($c), 0, 2
));}, [$c ? ju_cts($c) : 'Justuno\Core', $del]);}