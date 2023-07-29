<?php
use Justuno\Core\Exception as E;
use Justuno\Core\Xml\X;

/**
 * @used-by ju_module_name_by_path()
 * @param string|X $x
 * @return X|null
 * @throws E
 */
function ju_xml_parse($x, bool $throw = true) {/** @var X $r */
	if ($x instanceof X) {
		$r = $x;
	}
	else {
		ju_param_sne($x, 0);
		$r = null;
		try {$r = new X($x);}
		catch (\Exception $e) {
			if ($throw) {
				ju_error(
					"При синтаксическом разборе документа XML произошёл сбой:\n"
					. "«%s»\n"
					. "********************\n"
					. "%s\n"
					. "********************\n"
					, ju_xts($e)
					, ju_trim($x)
				);
			}
		}
	}
	return $r;
}