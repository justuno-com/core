<?php
use Df\Framework\W\Result as wResult;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Framework\App\Response\HttpInterface as IHttpResponse;
use Magento\Framework\Controller\ResultInterface as IResult;

/**
 * I pass the 3rd argument ($replace = true) to @uses \Magento\Framework\HTTP\PhpEnvironment\Response::setHeader()
 * because the `Content-Type` headed can be already set.
 * 2020-08-21 "Port the `df_response_content_type` function" https://github.com/justuno-com/core/issues/234
 * @used-by \Justuno\M2\W\Result\Js::render()
 * @param string $contentType
 * @param IResult|wResult|IHttpResponse|HttpResponse|null $r [optional]
 */
function ju_response_content_type($contentType, $r = null) {df_response($r)->setHeader('Content-Type', $contentType, true);}