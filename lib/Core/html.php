<?php
use Justuno\Core\Format\Html\Tag;
/**
 * 2015-10-27
 * 2020-08-22 "Port the `ju_link_inline` function" https://github.com/justuno-com/core/issues/247
 * @used-by ju_fe_init()
 * @param string|string[] $a
 * @return string|string[]
 */
function ju_link_inline(...$a) {return ju_call_a(function(string $res):string {return ju_resource_inline(
	$res, function(string $url):string {return ju_tag(
		'link', ['href' => $url, 'rel' => 'stylesheet', 'type' => 'text/css'], null, false
	);}
);}, $a);}

/**
 * 2015-12-11
 * 2020-08-22 "Port the `df_resource_inline` function" https://github.com/justuno-com/core/issues/256
 * @used-by ju_link_inline()
 */
function ju_resource_inline(string $r, Closure $f):string {
	static $c; /** @var array(string => bool) $c */
	if (!$r || isset($c[$r])) {$result = '';}
	else {$c[$r] = true; $result = $f(ju_asset_create($r)->getUrl());}
	return $result;
}

/**
 * 2015-04-16
 * From now on you can pass an array as an attribute's value: @see \Df\Core\Format\Html\Tag::getAttributeAsText()
 * It can be useful for attrivutes like `class`.
 * 2016-05-30 From now on $attrs could be a string. It is the same as ['class' => $attrs].
 * 2020-08-22 "Port the `df_tag` function" https://github.com/justuno-com/core/issues/253
 * @used-by ju_js_x()
 * @used-by ju_link_inline()
 * @param string|array(string => string|string[]|int|null) $attrs [optional]
 * @param string|null|string[] $content [optional]
 * @param bool|null $multiline [optional]
 */
function ju_tag(string $tag, $attrs = [], $content = null, $multiline = null):string {
	$t = new Tag($tag, is_array($attrs) ? $attrs : ['class' => $attrs], $content, $multiline); /** @vat Tag $t */
	return $t->render();
}