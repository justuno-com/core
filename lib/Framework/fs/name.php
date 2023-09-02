<?php

/**
 * Возвращает неиспользуемое имя файла в заданной папке $directory по заданному шаблону $template.
 * Результатом всегда является непустая строка.
 * 2020-06-21 "Port the `df_file_name` function": https://github.com/justuno-com/core/issues/102
 * @used-by ju_report()
 */
function ju_file_name(string $directory, string $template, string $ds = '-'):string { /** @var string $r */
	# 2016-11-09 If $template contains the file's path, when it will be removed from $template and added to $directory.
	$directory = ju_path_n($directory);
	$template = ju_path_n($template);
	if (ju_contains($template, '/')) {
		$templateA = explode('/', $template); /** @var string[] $templateA */
		$template = array_pop($templateA);
		$directory = ju_cc_path($directory, $templateA);
	}
	$counter = 1; /** @var int $counter */
	$hasOrderingPosition = ju_contains($template, '{ordering}');/** @var bool $hasOrderingPosition */
	$now = Zend_Date::now()->setTimezone('Europe/Moscow'); /** @var Zend_Date $now */
	/** @var array(string => string) $vars */
	$vars = ju_map_k(function($k, $v) use($ds, $now) {return
		ju_dts($now, implode($ds, $v))
		;}, ['date' => ['y', 'MM', 'dd'], 'time' => ['HH', 'mm'], 'time-full' => ['HH', 'mm', 'ss']]);
	/**
	 * 2016-11-09
	 * @see \Zend_Date неправильно работает с миллисекундами:
	 * всегда возвращает 0 вместо реального количества миллисекунд.
	 * Так происходит из-за дефекта в методах
	 * @see \Zend_Date::addMilliSecond()
	 * @see \Zend_Date::setMilliSecond()
	 * Там такой код:
	 *		list($milli, $time) = explode(" ", microtime());
	 *		$milli = intval($milli);
	 * https://github.com/OpenMage/magento-mirror/blob/1.9.3.0/lib/Zend/Date.php#L4490-L4491
	 * Этот код ошибочен, потому что после первой операции
	 * $milli содержит дробное значение меньше 1, например: 0.653...
	 * А вторая операция тупо делает из этого значения 0.
	 */
	$vars['time-full-ms'] = implode($ds, [$vars['time-full'], sprintf(
		'%02d', round(100 * ju_first(explode(' ', microtime())))
	)]);
	while (true) {
		/** @var string $fileName */
		$fileName = ju_var($template, ['ordering' => sprintf('%03d', $counter)] + $vars);
		$fileFullPath = $directory . DS . $fileName; /** @var string $fileFullPath */
		if (!file_exists($fileFullPath)) {
			$r = $fileFullPath;
			break;
		}
		elseif ($counter > 999) {
			ju_error("The counter has exceeded the $counter limit.");
		}
		else {
			$counter++;
			if (!$hasOrderingPosition && (2 === $counter)) {
				/** @var string[] $fileNameTemplateExploded */
				$fileNameTemplateExploded = explode('.', $template);
				/** @var int $secondFromLastPartIndex*/
				$secondFromLastPartIndex =  max(0, count($fileNameTemplateExploded) - 2);
				/** @var string $secondFromLastPart */
				$secondFromLastPart = jua($fileNameTemplateExploded, $secondFromLastPartIndex);
				ju_assert_sne($secondFromLastPart);
				$fileNameTemplateExploded[$secondFromLastPartIndex] =
					implode('--', [$secondFromLastPart, '{ordering}'])
				;
				$template = ju_assert_ne($template, implode('.', $fileNameTemplateExploded));
			}
		}
	}
	return ju_path_n($r);
}