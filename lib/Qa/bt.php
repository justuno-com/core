<?php

/**
 * 2020-06-16 "Port the `df_bt` function": https://github.com/justuno-com/core/issues/27
 * @used-by \Justuno\Core\Exception::__construct()
 * @param int $levelsToSkip
 */
function ju_bt($levelsToSkip = 0) {df_report('bt-{date}-{time}.log', df_bt_s(++$levelsToSkip));}