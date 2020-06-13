<?php
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\App\RequestInterface as IRequest;

/**
 * 2020-06-13 "Port the `df_request` function": https://github.com/justuno-com/core/issues/1
 * @used-by \Justuno\M2\Controller\Cart\Add::execute()
 * @used-by \Justuno\M2\Controller\Cart\Add::product()
 * @used-by \Justuno\M2\Filter::byDate()
 * @used-by \Justuno\M2\Filter::byProduct()
 * @used-by \Justuno\M2\Filter::p()
 * @param string|string[]|null $k [optional]
 * @param string|null|callable $d [optional]
 * @return string|array(string => string)
 */
function ju_request($k = null, $d = null) {$o = ju_request_o(); return is_null($k) ? $o->getParams() : (
	is_array($k) ? jua($o->getParams(), $k) : ju_if1(is_null($r = $o->getParam($k)) || '' === $r, $d, $r)
);}

/**
 * 2020-06-13 "Port the `df_request_o` function": https://github.com/justuno-com/core/issues/2
 * @return IRequest|RequestHttp
 */
function ju_request_o() {return ju_o(IRequest::class);}