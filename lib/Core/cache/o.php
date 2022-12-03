<?php
use Justuno\Core\RAM;

/**
 * 2020-06-13 "Port the `df_ram` function": https://github.com/justuno-com/core/issues/8
 * @used-by jucf()
 */
function ju_ram():RAM {return RAM::s();}