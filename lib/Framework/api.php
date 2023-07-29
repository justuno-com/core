<?php
use Magento\Framework\Api\AbstractSimpleObject as oAPI;

/**
 * 2023-07-29
 * @used-by ju_gd()
 * @used-by ju_has_gd()
 * @param mixed $v
 */
function ju_is_api_o($v):bool {return $v instanceof oAPI;}