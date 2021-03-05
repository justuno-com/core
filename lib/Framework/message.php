<?php
use Magento\Framework\Message\Manager as MM;
use Magento\Framework\Message\ManagerInterface as IMM;
use Magento\Framework\Message\MessageInterface as IM;
use Magento\Framework\Phrase as P;

/**
 * 2016-08-02
 * An arbitrary non-existent identifier allows to preserve the HTML tags in the message.
 * @see \Magento\Framework\View\Element\Message\InterpretationMediator::interpret()
 * https://github.com/magento/magento2/blob/2.1.0/lib/internal/Magento/Framework/View/Element/Message/InterpretationMediator.php#L26-L43
 * @used-by ju_message_error()
 * @used-by ju_message_success()
 * @param P|string $s
 * @param string $type
 */
function ju_message_add($s, $type) {ju_message_m()->addMessage(
	ju_message_m()->createMessage($type, 'non-existent')->setText(ju_phrase($s)), null
);}

/**
 * 2016-08-02
 * @used-by \Justuno\Core\Config\Backend::save()
 * @param string|P|\Exception $m
 */
function ju_message_error($m) {ju_message_add(df_ets($m), IM::TYPE_ERROR);}

/**
 * 2016-08-02 https://mage2.pro/t/974
 * @used-by ju_message_add()
 * @return IMM|MM
 */
function ju_message_m() {return ju_o(IMM::class);}

/**
 * 2016-12-04
 * @param string|P $m
 */
function ju_message_success($m) {ju_message_add($m, IM::TYPE_SUCCESS);}