<?php
/**
 * 2020-06-20 "Port the `df_normalize` function": https://github.com/justuno-com/core/issues/87
 * http://darklaunch.com/2009/05/06/php-normalize-newlines-line-endings-crlf-cr-lf-unix-windows-mac
 * @param string $s
 * @return string
 */
function ju_normalize($s) {return strtr($s, ["\r\n" => "\n", "\r" => "\n"]);}