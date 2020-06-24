<?php
use Magento\Framework\App\Area as A;

/**
 * 2017-04-02 «Area code is not set» on a df_area_code_is() call: https://mage2.pro/t/3581
 * 2020-06-24 "Port the `df_area_code` function": https://github.com/justuno-com/core/issues/127
 * @used-by ju_area_code_is()
 * @param bool $throw [optional]
 * @return string|null
 * @throws \Exception
 */
function ju_area_code($throw = true) {
	try {return ju_app_state()->getAreaCode();}
	catch (\Exception $e) {
		if ($throw) {
			throw $e;
		}
		return null;
	}
}

/**
 * 2016-09-30
 * 2017-04-02 «Area code is not set» on a df_area_code_is() call: https://mage2.pro/t/3581
 * 2020-06-24 "Port the `df_area_code_is` function": https://github.com/justuno-com/core/issues/126
 * @used-by ju_is_backend()
 * @param string ...$values
 * @return bool
 */
function ju_area_code_is(...$values) {return ($a = ju_area_code(false)) && in_array($a, $values);}

/**
 * 2015-08-14
 * 2020-06-24 "Port the `df_is_backend` function": https://github.com/justuno-com/core/issues/125
 * @used-by ju_store()
 * @return bool
 */
function ju_is_backend() {return ju_area_code_is(A::AREA_ADMINHTML) || ju_is_ajax() && ju_backend_user();}