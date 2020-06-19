<?php
/**
 * 2020-06-18 "Port the `df_pad` function": https://github.com/justuno-com/core/issues/64
 * @used-by ju_kv()
 * @param string $phrase
 * @param int $length
 * @param string $pattern
 * @param int $position
 * @return string
 */
function ju_pad($phrase, $length, $pattern = ' ', $position = STR_PAD_RIGHT) {/** @var string $r */
	$encoding = 'UTF-8'; /** @var string $encoding */
	$input_length = mb_strlen($phrase, $encoding); /** @var int $input_length */
	$pad_string_length = mb_strlen($pattern, $encoding); /** @var int $pad_string_length */
	if ($length <= 0 || $length - $input_length <= 0) {
		$r = $phrase;
	}
	else {
		$num_pad_chars = $length - $input_length; /** @var int $num_pad_chars */
		/** @var int $left_pad */ /** @var int $right_pad */
		switch ($position) {
			case STR_PAD_RIGHT:
				list($left_pad, $right_pad) = [0, $num_pad_chars];
				break;
			case STR_PAD_LEFT:
				list($left_pad, $right_pad) = [$num_pad_chars, 0];
				break;
			case STR_PAD_BOTH:
				$left_pad = floor($num_pad_chars / 2);
				$right_pad = $num_pad_chars - $left_pad;
				break;
			default:
				df_error();
				break;
		}
		$r = '';
		for ($i = 0; $i < $left_pad; ++$i) {
			$r .= mb_substr($pattern, $i % $pad_string_length, 1, $encoding);
		}
		$r .= $phrase;
		for ($i = 0; $i < $right_pad; ++$i) {
			$r .= mb_substr($pattern, $i % $pad_string_length, 1, $encoding);
		}
	}
	return $r;
}

/**
 * 2020-06-18 "Port the `df_tab` function": https://github.com/justuno-com/core/issues/85
 * @param string ...$args
 * @return string|string[]|array(string => string)
 */
function df_tab(...$args) {return ju_call_a(function($text) {return "\t" . $text;}, $args);}

/**
 * 2020-06-18 "Port the `df_tab_multiline` function": https://github.com/justuno-com/core/issues/84
 * @used-by \Justuno\Core\Qa\Dumper::dumpArray()
 * @param string $text
 * @return string
 */
function ju_tab_multiline($text) {return ju_cc_n(df_tab(df_explode_n($text)));}