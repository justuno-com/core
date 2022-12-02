<?php
namespace Justuno\Core\Framework;
use Magento\Framework\DB\Adapter\AdapterInterface as IAdapter;
use Magento\Framework\DB\Adapter\Pdo\Mysql as Adapter;
use Magento\Framework\Module\Setup as FSetup;
use Magento\Framework\Setup\ModuleContextInterface as IModuleContext;
use Magento\Setup\Model\ModuleContext;
use Magento\Setup\Module\Setup as SSetup;
/**
 * 2016-12-08
 * Нам достаточно реализовывать только классы Upgrade,
 * а классы Install можно не делать, потому что при обновлении ядро вызывает только классы Upgrade,
 * а при первичной установке — оба класса (Install и Upgrade),
 * причём оба являются факультативными:
 *		$installer = $this->getSchemaDataHandler($moduleName, $installType);
 *		if ($installer) {
 *			$this->log->logInline("Installing $type... ");
 *			$installer->install($setup, $moduleContextList[$moduleName]);
 *		}
 *		$upgrader = $this->getSchemaDataHandler($moduleName, $upgradeType);
 *		if ($upgrader) {
 *			$this->log->logInline("Upgrading $type... ");
 *			$upgrader->upgrade($setup, $moduleContextList[$moduleName]);
 *		}
 * https://github.com/magento/magento2/blob/2.1.2/setup/src/Magento/Setup/Model/Installer.php#L840-L850
 * 2020-08-21 "Port the `Df\Framework\Upgrade` class" https://github.com/justuno-com/core/issues/228
 * @see \Justuno\Core\Framework\Upgrade\Schema
 */
abstract class Upgrade {
	/**
	 * 2016-12-08
	 * @used-by self::process()
	 * @see \Justuno\M2\Setup\UpgradeSchema::_process()
	 */
	abstract protected function _process():void;

	/**
	 * 2016-12-08
	 * @used-by self::column()
	 * @return Adapter|IAdapter
	 */
	final protected function c() {return $this->_setup->getConnection();}

	/**
	 * 2016-08-14
	 * @used-by \Justuno\Core\Framework\Upgrade\Schema::upgrade()
	 */
	final protected function process(FSetup $setup, IModuleContext $context):void {
		$setup->startSetup();
		$this->_context = $context;
		$this->_setup = $setup;
		$this->_process();
		$setup->endSetup();
	}

	/**
	 * 2018-03-21
	 * @return FSetup|SSetup
	 */
	final protected function setup() {return $this->_setup;}

	/**
	 * 2016-12-08
	 * 2017-08-01 It does the same as @see df_table().
	 * The sole difference: $this->t() expression can be used inside PHP strings, but df_table can not.
	 * E.g.:
	 *		CREATE TABLE IF NOT EXISTS `{$this->t($name)}` (
	 *			`value_id` int(11) NOT NULL
	 *			,`{$f_MARKDOWN}` text
	 *			,PRIMARY KEY (`{$f_VALUE_ID}`)
	 *			,FOREIGN KEY (`{$f_VALUE_ID}`)
	 *				REFERENCES `{$this->t($master)}` (`value_id`)
	 *				ON DELETE CASCADE
	 *			) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
	 *		");
	 * https://github.com/mage2pro/markdown/blob/1.0.24/Setup/UpgradeSchema.php#L74-L82
	 * @param string|array $t
	 * @return string
	 */
	final protected function t($t) {return $this->_setup->getTable($t);}

	/**
	 * 2016-08-21
	 * 2017-08-01 It checks whether the installed version of the current module is lower than $v.
	 * @used-by \Justuno\M2\Setup\UpgradeSchema::_process()
	 * @param string $v
	 * @return bool
	 */
	final protected function v($v) {return -1 === version_compare($this->_context->getVersion(), $v);}

	/**
	 * 2016-12-02
	 * @used-by self::process()
	 * @used-by self::v()
	 * @var IModuleContext|ModuleContext
	 */
	private $_context;

	/**
	 * 2016-12-02
	 * @used-by self::c()
	 * @used-by self::process()
	 * @used-by self::sEav()
	 * @used-by self::setup()
	 * @used-by self::t()
	 * @var FSetup|SSetup
	 */
	private $_setup;
}