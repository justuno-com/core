<?php
use Magento\Framework\App\ProductMetadata;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\App\State;
/**
 * 2015-09-20
 * 2020-06-24 "Port the `df_app_state` function": https://github.com/justuno-com/core/issues/128
 * @used-by ju_area_code()
 * @return State
 */
function ju_app_state() {return ju_o(State::class);}