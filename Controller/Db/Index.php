<?php
namespace Justuno\Core\Controller\Db;
use Magento\Framework\View\Result\Page as R;
# 2021-02-22
# "Implement a database diagnostic tool": https://github.com/justuno-com/core/issues/347
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Index extends \Justuno\Core\Framework\Action {
	/**
	 * 2021-02-22
	 * @override
	 * @see _P::execute()
	 * @used-by \Magento\Framework\App\Action\Action::dispatch():
	 * 		$result = $this->execute();
	 * https://github.com/magento/magento2/blob/2.2.1/lib/internal/Magento/Framework/App/Action/Action.php#L84-L125
	 * @return R
	 */
	function execute() {return ju_page_result('Justuno_Core::db.php');}
}