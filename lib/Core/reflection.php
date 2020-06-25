<?php
use Df\Core\R\ConT;
use Justuno\Core\Exception as DFE;
use ReflectionClass as RC;

/**
 * 2020-06-26 "Port the `df_explode_class` function": https://github.com/justuno-com/core/issues/139
 * @used-by ju_module_name()
 * @param string|object $c
 * @return string[]
 */
function ju_explode_class($c) {return df_explode_multiple(['\\', '_'], df_cts($c));}