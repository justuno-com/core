<?php
/**
 * 2015-11-13
 * 2020-08-22 "Port the `df_map_to_options_t` function" https://github.com/justuno-com/core/issues/260
 * @used-by \Justuno\Core\Config\Source::toOptionArray()
 * @uses ju_option()
 * @param array(string|int => string) $m
 * @return array(array(string => string|int))
 */
function ju_map_to_options_t(array $m) {return array_map('ju_option', array_keys($m), df_translate_a($m));}

/**
 * 2020-08-22 "Port the `df_option` function" https://github.com/justuno-com/core/issues/261
 * @used-by ju_map_to_options_t()
 * @param string|int $v
 * @param string $l
 * @return array(string => string|int)
 */
function ju_option($v, $l) {return ['label' => $l, 'value' => $v];}