<?php
use Justuno\Core\RAM;

/**
 * 2020-06-13 "Port the `df_ram` function": https://github.com/justuno-com/core/issues/8
 * @used-by jucf()
 * @return RAM
 */
function ju_ram() {return RAM::s();}