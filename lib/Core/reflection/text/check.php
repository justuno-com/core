<?php
/**
 * 2016-01-01
 * 2016-10-20
 * Making $c optional leads to the error «get_class() called without object from outside a class»: https://3v4l.org/k6Hd5
 * https://3v4l.org/k6Hd5
 * 2020-08-22 "Port the `df_class_my` function" https://github.com/justuno-com/core/issues/263
 * @used-by \Justuno\Core\Config\Plugin\Model\Config\SourceFactory::aroundCreate()
 * @param string|object $c
 * @return bool
 */
function ju_class_my($c) {return in_array(ju_class_f($c), ['Justuno']);}
