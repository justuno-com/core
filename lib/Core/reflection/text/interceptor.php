<?php
/**
 * 2021-03-25
 * @used-by ju_interceptor()
 * @used-by ju_trim_interceptor()
 */
const JU_INTERCEPTOR = '\Interceptor';

/**
 * 2021-03-26
 * @used-by df_cts()
 */
function ju_trim_interceptor(string $c):string {return ju_trim_text_right($c, JU_INTERCEPTOR);}