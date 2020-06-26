<?php
use Magento\Framework\App\Config\ScopeConfigInterface as IScopeConfig;
use Magento\Framework\App\ScopeInterface as ScopeA;
use Magento\Framework\App\ScopeResolverPool;
use Magento\Store\Model\ScopeInterface as SS;
use Magento\Store\Model\Store;

/**
 * 2015-12-26
 * https://mage2.pro/t/359
 * «Propose to make the @see \Magento\Framework\App\Config\ScopePool::_getScopeCode() public
 * because it is useful to calculate cache keys based on a scope
 * (like @see \Magento\Framework\App\Config\ScopePool::getScope() does)».
 *
 * 2015-12-26
 * I use @see \Magento\Store\Model\ScopeInterface::SCOPE_STORE as the default value for $scopeType
 * for compatibility with @see \Df\Config\Settings::v()
 * https://mage2.pro/t/128
 * https://github.com/magento/magento2/issues/2064
 *
 * 2017-10-22
 * Note 1.
 * The @see \Magento\Framework\App\ScopeInterface::SCOPE_DEFAULT constant is absent in Magento <= 2.2.0:
 * https://github.com/magento/magento2/blob/2.1.9/lib/internal/Magento/Framework/App/ScopeInterface.php
 * https://github.com/magento/magento2/blob/2.2.0/lib/internal/Magento/Framework/App/ScopeInterface.php#L13-L16
 * «Undefined class constant 'SCOPE_DEFAULT' in mage2pro/core/Config/lib/scope.php on line 36»:
 * https://github.com/mage2pro/core/issues/39
 *
 * Note 2.
 * The @see \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT constant
 * exists in all the Magento 2 versions:
 * https://github.com/magento/magento2/blob/2.0.0/lib/internal/Magento/Framework/App/Config/ScopeConfigInterface.php#L16-L19
 * It is not deprecated in Magento 2.2.0:
 * https://github.com/magento/magento2/blob/2.2.0/lib/internal/Magento/Framework/App/Config/ScopeConfigInterface.php#L16-L19
 *
 * Note 3.
 * The @see \Magento\Config\Block\System\Config\Form::SCOPE_DEFAULT constant exists in all the Magento 2 versions:
 * https://github.com/magento/magento2/blob/2.0.0/app/code/Magento/Config/Block/System/Config/Form.php#L16
 * It is not deprecated in Magento 2.2.0:
 * https://github.com/magento/magento2/blob/2.2.0/app/code/Magento/Config/Block/System/Config/Form.php#L26
 *
 * Note 4.
 * The @see \Magento\Store\Model\ScopeInterface::SCOPE_STORE constant exists in all the Magento 2 versions:
 * https://github.com/magento/magento2/blob/2.0.0/app/code/Magento/Store/Model/ScopeInterface.php#L17
 *
 * 2020-06-26 "Port the `df_scope_code` function": https://github.com/justuno-com/core/issues/156
 *
 * @used-by ju_store_code()
 * @param null|string|int|ScopeA|Store $scope [optional]
 * @param string $scopeType [optional]
 * @return string
 */
function ju_scope_code($scope = null, $scopeType = SS::SCOPE_STORE) {
	if (($scope === null || is_numeric($scope)) && $scopeType !== IScopeConfig::SCOPE_TYPE_DEFAULT) {
		$scope = ju_scope_resolver_pool()->get($scopeType)->getScope($scope);
	}
	return $scope instanceof ScopeA ? $scope->getCode() : $scope;
}

/**
 * 2016-12-16
 * 2020-06-26 "Port the `df_scope_resolver_pool` function": https://github.com/justuno-com/core/issues/157
 * @used-by ju_scope_code()
 * @return ScopeResolverPool
 */
function ju_scope_resolver_pool() {return ju_o(ScopeResolverPool::class);}