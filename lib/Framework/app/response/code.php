<?php
use Magento\Framework\App\ResponseInterface as IResponse;
use Magento\Framework\App\Response\Http as HttpResponse;

/**
 * 2021-04-19 https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/403#content
 * @return IResponse|HttpResponse
 */
function ju_403() {return ju_response_code(403);}

/**
 * 2015-11-29
 * @used-by ju_403()
 * @return IResponse|HttpResponse
 */
function ju_response_code(int $v) {return ju_response()->setHttpResponseCode($v);}