<?php
/**
 * 2018-01-29
 * 2020-08-22 "Port the `df_map_0` function" https://github.com/justuno-com/core/issues/265
 * @used-by \Justuno\M2\Config\Source\Brand::map()
 * @param array(string => string) $tail
 * @return array(int => string)
 */
function ju_map_0(array $tail, string $l = ''):array {return [0 => $l ?: '-- select a value --'] + $tail;}

/**
 * 2015-02-11 Превращает массив вида ['value' => 'label'] в массив вида [['value' => '', 'label' => '']].
 * 2020-08-22 "Port the `df_map_to_options_t` function" https://github.com/justuno-com/core/issues/260
 * @used-by \Justuno\Core\Config\Source::toOptionArray()
 * @uses ju_option()
 * @param array(string|int => string) $m
 * @return array(array(string => string|int))
 */
function ju_map_to_options_t(array $m):array {return array_map('ju_option', array_keys($m), ju_translate_a($m));}

/**
 * 2020-08-22 "Port the `df_option` function" https://github.com/justuno-com/core/issues/261
 * @used-by ju_map_to_options_t()
 * @param string|int $v
 * @return array(string => string|int)
 */
function ju_option($v, string $l):array {return ['label' => $l, 'value' => $v];}