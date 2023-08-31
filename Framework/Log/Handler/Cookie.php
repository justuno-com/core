<?php
namespace Justuno\Core\Framework\Log\Handler;
# 2020-02-18, 2020-02-21, 2021-09-08
# "Prevent Magento from logging the «Unable to send the cookie. Maximum number of cookies would be exceeded.» message":
# https://github.com/tradefurniturecompany/site/issues/53
final class Cookie extends \Justuno\Core\Framework\Log\Handler {
	/**
	 * 2021-09-08
	 * @override
	 * @see \Justuno\Core\Framework\Log\Handler::_p()
	 * @used-by \Justuno\Core\Framework\Log\Handler::p()
	 */
	protected function _p():bool {return $this->r()->msg(
		'Unable to send the cookie. Maximum number of cookies would be exceeded.'
	);}
}