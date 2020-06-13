<?php

/**
 * 2020-06-13 "Port the `df_ita` function": https://github.com/justuno-com/core/issues/15
 * @param \Traversable|array $t
 * @return array
 */
function ju_ita($t) {return is_array($t) ? $t : iterator_to_array($t);}