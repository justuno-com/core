<?php
use Justuno\Core\O;
use Magento\Backend\Block\Template as BackendTemplate;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\Element\Template;
/**
 * 2020-08-22 "Port the `df_block` function" https://github.com/justuno-com/core/issues/238
 * @used-by \Justuno\M2\Block\GenerateToken::getElementHtml()
 * @param string|O|null $c
 * @param string|array(string => mixed) $data [optional]
 * @param string|null $template [optional]
 * @param array $vars [optional]
 * @return AbstractBlock|BlockInterface|Template
 */
function ju_block($c, $data = [], $template = null, array $vars = []) {
	if (is_null($c)) {
		$c = ju_is_backend() ? BackendTemplate::class : Template::class;
	}
	/** @var string|null $template */
	if (is_string($data)) {
		$template = $data;
		$data = [];
	}
	/** @var AbstractBlock|BlockInterface|Template $r */
	$r = df_layout()->createBlock($c, dfa($data, 'name'), ['data' => $data]);
	# 2019-06-11
	if ($r instanceof Template) {
		# 2016-11-22
		$r->assign($vars);
	}
	if ($template && $r instanceof Template) {
		$r->setTemplate(df_file_ext_add($template, 'phtml'));
	}
	return $r;
}