<?php
use Df\Backend\Model\Auth;
use Df\Customer\Model\Session as DfSessionC;
use Magento\Backend\Model\Auth\Session as SessionB;
use Magento\Customer\Model\Session as SessionC;
use Magento\User\Model\User;

/**
 * 2016-12-23
 * 2020-06-24 "Port the `df_backend_session` function": https://github.com/justuno-com/core/issues/131
 * @used-by ju_backend_user()
 * @return SessionB
 */
function ju_backend_session() {return ju_o(SessionB::class);}

/**
 * 2016-12-23
 * 2020-06-24 "Port the `df_backend_user` function": https://github.com/justuno-com/core/issues/130
 * @used-by ju_is_backend()
 * @return User|null
 */
function ju_backend_user() {return ju_backend_session()->getUser();}