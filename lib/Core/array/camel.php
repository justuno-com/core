<?php
/**
 * «YandexMarket» => array(«Yandex», «Market»)
 * «NewNASAModule» => array(«New», «NASA», «Module»)
 * http://stackoverflow.com/a/17122207
 *
 * 2016-08-24
 * http://php.net/manual/reference.pcre.pattern.modifiers.php
 * x (PCRE_EXTENDED)
 * 		If this modifier is set, whitespace data characters in the pattern are totally ignored
 * 		except when escaped or inside a character class,
 * 		and characters between an unescaped # outside a character class
 * 		and the next newline character, inclusive, are also ignored.
 *
 * 		This is equivalent to Perl's /x modifier,
 * 		and makes it possible to include commentary inside complicated patterns.
 *
 * 		Note, however, that this applies only to data characters.
 * 		Whitespace characters may never appear within special character sequences in a pattern,
 * 		for example within the sequence (?( which introduces a conditional subpattern.
 *
 * 2017-07-09
 * Note 1: ?<=
 * «Zero-width positive lookbehind assertion.
 * Continues match only if the subexpression matches at this position on the left.
 * For example, (?<=19)99 matches instances of 99 that follow 19.
 * This construct does not backtrack.»
 *
 * Note 2: ?=
 * «Zero-width positive lookahead assertion.
 * Continues match only if the subexpression matches at this position on the right.
 * For example, \w+(?=\d) matches a word followed by a digit, without matching the digit.
 * This construct does not backtrack.»
 *
 * I have extracted this explanation from Rad Software Regular Expression Designer
 * (it is a discontinued software, google for it),
 * and it get it from the .NET Framework 3.0 documentation:
 * https://msdn.microsoft.com/en-us/library/bs2twtah(v=vs.85).aspx
 *
 * Note 3.
 * Today I have changed «?=[A-Z0-9]» => «?=[A-Z0-9]», so now it handles the cases with digits, e.g.:
 * «Dynamics365» => [«Dynamics», «365»]
 *
 * 2020-08-21 "Port the `df_explode_camel` function" https://github.com/justuno-com/core/issues/221
 *
 * @used-by ju_explode_class_camel()
 * @param string|string[] $a
 * @return string[]|string[][]
 */
function ju_explode_camel(...$a):array {return ju_call_a(function(string $n) {return preg_split(
	'#(?<=[a-z])(?=[A-Z0-9])#x', $n
);}, $a);}