<?php
namespace Justuno\Core\Zf\Filter;
# 2020-06-20 "Port the `Justuno\Core\Zf\Filter\StringTrim` class": https://github.com/justuno-com/core/issues/90
/** @used-by ju_trim() */
final class StringTrim extends \Zend_Filter_StringTrim {
	/**
	 * 2022-12-14 We can not declare arguments types because they are undeclared in the overriden method.
	 * @override
	 * @see \Zend_Filter_StringTrim::_unicodeTrim()
	 * @param string $s
	 * @param string $charlist
	 */
	protected function _unicodeTrim($s, $charlist = '\\\\s'):string {/** @var string $r */
		if (ju_es($s)) {
			$r = $s;
		}
		else {
			# Начало кода из Zend Framework 2.0
			$chars = preg_replace(
				['/[\^\-\]\\\]/S', '/\\\{4}/S', '/\//'],
				['\\\\\\0', '\\', '\/'],
				$charlist
			);
  			$pattern = '/^[' . $chars . ']+|[' . $chars . ']+$/usSD';
			$r = preg_replace($pattern, '', $s);
			# Конец кода из Zend Framework 2.0
			if (null === $r) {
				/**
				 * Раньше тут происходил вызов @see df_notify_me().
				 * Заменил вызов @see df_notify_me() на @see df_notify_exception(),
				 * чтобы установить первоисточник странного поведения системы,
				 * когда в конец веб-адреса добавляется некий текстовый мусор в неверной кодировке
				 * (похожий на кусок диагностического сообщения),
				 * и затем этот веб-адрес попадает в данный метод,
				 * что приводит нас данную точку.
				 * Веб-адрес с мусором на конце может быть, например, таким:
				 * «/contacts/index/++++++++++++++++++++++++++++++++++++++++++Result:+�å+������ü+����û+��ÿ+�������è;»
				 * Неверность кодировки объясняется, видимо, функциями ядра для работы с веб-адресами.
				 */
				$r = $this->_slowUnicodeTrim($s, $charlist);
			}
		}
		return $r;
	}

	/** @used-by self::_unicodeTrim() */
	private function _slowUnicodeTrim(string $s, string $chars):string {
		$utfChars = $this->_splitUtf8($s);
		$pattern = '/^[' . $chars . ']$/usSD';
		while ($utfChars && preg_match($pattern, $utfChars[0])) {
			array_shift($utfChars);
		}
		while ($utfChars && preg_match($pattern, $utfChars[count($utfChars) - 1])) {
			array_pop($utfChars);
		}
		return implode($utfChars);
	}

	/**
	 * @used-by self::_slowUnicodeTrim()
	 * @return array|bool
	 */
	private function _splitUtf8(string $s) {
		try {
			$r = str_split(iconv('UTF-8', 'UTF-32BE', $s), 4);
		}
		catch (\Exception $e) {
			ju_error("The value is not encoded in UTF-8: «{$s}».");
		}
		array_walk($r, function(&$c) {$c = iconv('UTF-32BE', 'UTF-8', $c);});
		return $r;
	}
}