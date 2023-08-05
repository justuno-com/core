<?php
/**
 * @see ju_nes()
 * @used-by ju_path_is_internal()
 * @used-by ju_report()
 * @param mixed $v
 */
function ju_es($v):bool {return '' === $v;}

/**
 * 2017-04-26
 * 2020-08-26 "Port the `df_eta` function" https://github.com/justuno-com/core/issues/329
 * @used-by ju_caller_entry()
 * @used-by ju_caller_entry_m()
 * @used-by ju_fetch_one()
 * @used-by ju_package()
 * @param mixed|null $v
 * @return mixed[]
 */
function ju_eta($v):array {
	if (!is_array($v)) {
		ju_assert(empty($v));
		$v = [];
	}
	return $v;
}

/**
 * 2020-01-29
 * 2020-08-14 "Port the `df_etn` function" https://github.com/justuno-com/core/issues/181
 * @used-by ju_customer_session_id()
 * @used-by ju_slice()
 * @param mixed $v
 * @return mixed|null
 */
function ju_etn($v) {return $v ?: null;}

/**
 * 2023-07-26 "Implement `df_ets()`": https://github.com/mage2pro/core/issues/280
 * @used-by ju_log_l()
 * @param mixed $v
 * @return mixed|string
 */
function ju_ets($v) {return $v ?: '';}

/**
 * 2020-08-26 "Port the `df_ftn` function" https://github.com/justuno-com/core/issues/328
 * @used-by ju_fetch_one()
 * @param mixed|false $v
 * @return mixed|null
 */
function ju_ftn($v) {return false === $v ? null : $v;}

/**
 * 2022-10-15
 * @see ju_nts()
 * @used-by ju_module_file_name()
 * @param mixed|false $v
 * @return mixed|string
 */
function ju_fts($v) {return false === $v ? '' : $v;}

/**
 * 2020-06-14 "Port the `df_nes` function": https://github.com/justuno-com/core/issues/19
 * @see ju_es()
 * @used-by ju_cfg_empty()
 * @used-by ju_int()
 * @used-by ju_json_decode()
 * @used-by jua()
 * @used-by jua_deep()
 * @param mixed $v
 */
function ju_nes($v):bool {return is_null($v) || '' === $v;}

/**
 * 2020-06-20 "Port the `df_nts` function": https://github.com/justuno-com/core/issues/89
 * @used-by ju_trim()
 * @used-by \Justuno\Core\Qa\Trace\Frame::class_()
 * @used-by \Justuno\Core\Qa\Trace\Frame::function_()
 * @param mixed|null $v
 * @return mixed
 */
function ju_nts($v) {return !is_null($v) ? $v : '';}