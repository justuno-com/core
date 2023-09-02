<?php
use Justuno\Core\Framework\W\Result as wResult;
use Magento\Framework\App\ResponseInterface as IResponse;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Framework\App\Response\HttpInterface as IHttpResponse;
use Magento\Framework\Controller\ResultInterface as IResult;
use Magento\Framework\Webapi\Rest\Response as RestResponse;

/**
 * 2017-02-01
 * Добавил параметр $r.
 * IResult и wResult не родственны IResponse и HttpResponse.
 * 2017-11-17
 * You can read here more about the IResult/wResult and IResponse/HttpResponse difference:
 * 1) @see \Magento\Framework\App\Http::launch():
 *		# TODO: Temporary solution until all controllers return ResultInterface (MAGETWO-28359)
 *		if ($result instanceof ResultInterface) {
 *			$this->registry->register('use_page_cache_plugin', true, true);
 *			$result->renderResult($this->_response);
 *		} elseif ($result instanceof HttpInterface) {
 *			$this->_response = $result;
 *		} else {
 *			throw new \InvalidArgumentException('Invalid return type');
 *		}
 * https://github.com/magento/magento2/blob/2.2.1/lib/internal/Magento/Framework/App/Http.php#L122-L149
 * 2) "[Question] To ResultInterface or not ResultInterface": https://github.com/magento/magento2/issues/1355
 * https://github.com/magento/magento2/issues/1355
 * 2020-08-21 "Port the `ju_response` function" https://github.com/justuno-com/core/issues/235
 * @used-by ju_response_code()
 * @used-by ju_response_content_type()
 * @param IResult|wResult|IResponse|HttpResponse|null $r [optional]
 * @return IResponse|IHttpResponse|HttpResponse|IResult|wResult
 */
function ju_response($r = null) {return $r ?: ju_o(
	/**
	 * 2021-09-22
	 * 1) @uses \Magento\Framework\Webapi\Rest\Response implements
	 * @uses \Magento\Framework\App\ResponseInterface:
	 * 1.1)
	 * 		namespace Magento\Framework\Webapi\Rest;
	 * 		class Response extends \Magento\Framework\Webapi\Response
	 * https://github.com/magento/magento2/blob/2.0.0/lib/internal/Magento/Framework/Webapi/Rest/Response.php#L8-L10
	 * https://github.com/magento/magento2/blob/2.4.3/lib/internal/Magento/Framework/Webapi/Rest/Response.php#L8-L10
	 * 1.2)
	 * 		namespace Magento\Framework\Webapi;
	 * 		class Response
	 * 			extends \Magento\Framework\HTTP\PhpEnvironment\Response
	 * 			implements \Magento\Framework\App\Response\HttpInterface
	 * https://github.com/magento/magento2/blob/2.0.0/lib/internal/Magento/Framework/Webapi/Response.php#L8-L11
	 * https://github.com/magento/magento2/blob/2.4.3/lib/internal/Magento/Framework/Webapi/Response.php#L8-L11
	 * 1.3)
	 * 		namespace Magento\Framework\App\Response;
	 *		interface HttpInterface extends \Magento\Framework\App\ResponseInterface
	 * https://github.com/magento/magento2/blob/2.0.0/lib/internal/Magento/Framework/App/Response/HttpInterface.php#L8-L10
	 * https://github.com/magento/magento2/blob/2.4.3/lib/internal/Magento/Framework/App/Response/HttpInterface.php#L6-L14
	 * 2) But @uses \Magento\Framework\Webapi\Rest\Response is not instantiated via the
	 * @uses \Magento\Framework\App\ResponseInterface
	 * It is instantiated directly via the  `Magento\Framework\Webapi\Rest\Response` class name:
	 *		public function __construct(
	 *			RestResponse $response,
	 *			<…>
	 *		) {
	 *			$this->response = $response;
	 *			<…>
	 *		}
	 * https://github.com/magento/magento2/blob/2.4.3/app/code/Magento/Webapi/Controller/Rest/SynchronousRequestProcessor.php#L54-L78
	 */
	ju_is_rest() ? RestResponse::class : IResponse::class
);}

/**
 * I pass the 3rd argument ($replace = true) to @uses \Magento\Framework\HTTP\PhpEnvironment\Response::setHeader()
 * because the `Content-Type` headed can be already set.
 * 2020-08-21 "Port the `df_response_content_type` function" https://github.com/justuno-com/core/issues/234
 * @used-by \Justuno\Core\Framework\W\Result\Text::render()
 * @used-by \Justuno\M2\W\Result\Js::render()
 * @param IResult|wResult|IHttpResponse|HttpResponse|null $r [optional]
 */
function ju_response_content_type(string $t, $r = null):void {ju_response($r)->setHeader('Content-Type', $t, true);}