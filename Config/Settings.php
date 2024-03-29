<?php
namespace Justuno\Core\Config;
use Magento\Framework\App\ScopeInterface as S;
use Magento\Store\Model\Store;
/**
 * 2015-11-09
 * 2021-03-06 "Port the `Justuno\Core\Config\Settings` class": https://github.com/justuno-com/core/issues/355
 * @see \Justuno\M2\Settings
 */
abstract class Settings {
	/**
	 * 2015-11-09
	 * 2016-11-24 From now on, the value should not include the trailing `/`.
	 * @used-by \Justuno\Core\Config\Settings::v()
	 * @see \Justuno\M2\Settings::prefix()
	 */
	abstract protected function prefix():string;

	/**
	 * 2016-03-08
	 * 2017-10-25
	 * @uses ju_is_backend() is a dirty hack here:
	 * a call for @see ju_is_system_config()
	 * from @see \Dfe\Portal\Plugin\Theme\Model\View\Design::beforeGetConfigurationDesignTheme()
	 * breaks my frontend...
	 * https://github.com/mage2pro/portal/blob/0.4.4/Plugin/Theme/Model/View/Design.php#L13-L33
	 * Maybe @see \Dfe\Portal\Plugin\Store\Model\PathConfig::afterGetDefaultPath() is also an offender...
	 * https://github.com/mage2pro/portal/blob/0.4.4/Plugin/Store/Model/PathConfig.php#L7-L17
	 * @used-by self::v()
	 * @param null|string|int|S|Store|array(string, int) $s [optional]
	 * @return null|string|int|S|Store|array(string, int)
	 */
	final function scope($s = null) {return !is_null($s) ? $s : (
		ju_is_backend() && ju_is_system_config() ? ju_scope() : $this->scopeDefault()
	);}

	/**
	 * @used-by \Justuno\M2\Settings::accid()
	 * @used-by \Justuno\M2\Settings::brand_attribute()
	 * @used-by \Justuno\M2\Settings::domain()
	 * @param null|string|int|S|Store|array(string, int) $s [optional]
	 * @param mixed|callable $d [optional]
	 * @return array|string|null|mixed
	 */
	final function v(string $k = '', $s = null, $d = null) {return ju_cfg(
		$this->prefix() . '/' . self::phpNameToKey($k ?: ju_caller_f()), $this->scope($s), $d
	);}

	/**
	 * 2017-03-27
	 * @used-by self::scope()
	 * @return int|S|Store|null|string
	 */
	protected function scopeDefault() {return $this->_scope;}

	/**
	 * 2019-01-12
	 * @used-by self::s()
	 * @param int|S|Store|null|string $s
	 */
	private function __construct($s = null) {$this->_scope = $s;}

	/**
	 * 2019-01-11
	 * @used-by self::scopeDefault()
	 * @var int|S|Store|string|null
	 */
	private $_scope;

	/**
	 * 2016-07-12 https://php.net/manual/function.get-called-class.php#115790
	 * @used-by \Justuno\M2\Block\Js::_toHtml()
	 * @used-by \Justuno\M2\Controller\Response\Catalog::execute()
	 * @param Store|int|null $s [optional]
	 */
	static function s($s = null, string $c = ''):self {return jucf(
		function($s, $c) {return new $c($s);}, [ju_store($s), $c ?: static::class]
	);}

	/**
	 * 2016-12-24
	 * From now on, keys can have a leading digit (e.g.: «3DS»).
	 * PHP methods for such keys should be prefixed with «_».
	 * E.g., the @see \Dfe\Omise\Settings::_3DS() method handles the «test3DS» and «live3DS» keys.
	 * @used-by self::v()
	 */
	final protected static function phpNameToKey(string $n):string {return ju_trim_left($n, '_');}
}