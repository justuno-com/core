<?php
/**
 * Заменяет все сиволы пути на /
 * 2020-06-15 "Port the `df_path_n` function": https://github.com/justuno-com/core/issues/26
 * 2021-12-17 https://3v4l.org/8iP17
 * @used-by ju_adjust_paths_in_message()
 * @used-by ju_explode_path()
 * @used-by ju_file_name()
 * @used-by ju_path_abs()
 * @used-by ju_path_is_internal()
 * @used-by ju_path_relative()
 */
function ju_path_n(string $p):string {return str_replace(['\/', '\\'], '/', $p);}