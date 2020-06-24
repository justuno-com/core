<?php
use Df\Core\Exception as DFE;
use Df\Quote\Model\Quote as DfQ;
use Magento\Customer\Model\Customer as C;
use Magento\Payment\Model\InfoInterface as II;
use Magento\Quote\Model\Quote as Q;
use Magento\Quote\Model\Quote\Address as QA;
use Magento\Quote\Model\Quote\Item as QI;
use Magento\Quote\Model\Quote\Payment as QP;
use Magento\Sales\Model\Order as O;
use Magento\Sales\Model\Order\Address as OA;
use Magento\Sales\Model\Order\Item as OI;
use Magento\Sales\Model\Order\Payment as OP;

/**
 * 2017-04-10
 * 2020-06-24 "Port the `ju_is_o` function": https://github.com/justuno-com/core/issues/123
 * @used-by ju_store()
 * @param mixed $v
 * @return bool
 */
function ju_is_o($v) {return $v instanceof O;}

