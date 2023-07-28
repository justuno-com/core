<?php
/**
 * 2020-06-15 "Port the `df_path_n` function": https://github.com/justuno-com/core/issues/26
 * @used-by ju_adjust_paths_in_message()
 * @used-by ju_file_name()
 * @used-by ju_path_abs()
 * @used-by ju_path_is_internal()
 * @used-by ju_path_relative()
 */
function ju_path_n(string $p):string {return str_replace('//', '/', str_replace('\\', '/', $p));}