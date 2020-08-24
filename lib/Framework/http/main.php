<?php
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\App\RequestInterface as IRequest;

/**
 * 2020-06-17 "Port the `df_header_utf` function": https://github.com/justuno-com/core/issues/35
 * @used-by ju_error()
 */
function ju_header_utf() {ju_is_cli() || headers_sent() ?: header('Content-Type: text/html; charset=UTF-8');}

/**
 * 2020-06-13 "Port the `df_request` function": https://github.com/justuno-com/core/issues/1
 * @used-by ju_store()
 * @used-by \Justuno\Core\Sentry\Client::get_http_data()
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
 * 2016-12-25
 * The @uses \Laminas\Http\Request::getHeader() method is insensitive to the argument's letter case:
 * @see \Laminas\Http\Headers::createKey()
 * https://github.com/zendframework/zendframework/blob/release-2.4.6/library/Zend/Http/Headers.php#L462-L471
 * 2020-08-24 "Port the `df_request_header` function" https://github.com/justuno-com/core/issues/303
 * @used-by \Justuno\M2\Response::p()
 * @param string $k
 * @return string|false
 */
function ju_request_header($k) {return ju_request_o()->getHeader($k);}

/**
 * 2020-06-13 "Port the `df_request_o` function": https://github.com/justuno-com/core/issues/2
 * @used-by ju_action_name()
 * @used-by ju_is_ajax()
 * @used-by ju_log_l()
 * @used-by ju_request()
 * @used-by ju_request_header()
 * @used-by \Justuno\Core\Sentry\Client::get_http_data()
 * @return IRequest|RequestHttp
 */
function ju_request_o() {return ju_o(IRequest::class);}