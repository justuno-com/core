<?php
use Magento\Framework\Message\Manager as MM;
use Magento\Framework\Message\ManagerInterface as IMM;
use Magento\Framework\Message\MessageInterface as IM;
use Magento\Framework\Phrase as P;

/**
 * 2016-08-02 https://mage2.pro/t/974
 * @used-by ju_message_add()
 * @return IMM|MM
 */
function ju_message_m() {return ju_o(IMM::class);}