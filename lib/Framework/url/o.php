<?php
use Df\Backend\Model\Url as UrlBackend;
use Magento\Backend\Model\UrlInterface as IUrlBackend;
use Magento\Framework\Url;
use Magento\Framework\UrlInterface as IUrl;

/**
 * 2020-08-21 "Port the `ju_url_o` function" https://github.com/justuno-com/core/issues/213
 * @used-by ju_current_url()
 * @return IUrl|Url|IUrlBackend|UrlBackend
 */
function ju_url_o() {return ju_o(IUrl::class);}