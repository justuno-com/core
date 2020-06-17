<?php
/**
 * 2017-08-22
 * 2017-09-07 Be careful! If the $a array is not associative,
 * then df_ksort_r($a, 'strcasecmp') will convert the numeric arrays to associative ones,
 * and their numeric keys will be ordered as strings.
 * 2020-06-18 "Port the `df_ksort_r_ci` function": https://github.com/justuno-com/core/issues/67
 * @used-by df_json_sort()
 * @param array(int|string => mixed) $a
 * @return array(int|string => mixed)
 */
function ju_ksort_r_ci(array $a) {return !ju_is_assoc($a) ? $a : df_ksort_r($a, 'strcasecmp');}