<?php
use Justuno\Core\Format\Html\Tag;
/**
 * 2015-04-16
 * From now on you can pass an array as an attribute's value: @see \Df\Core\Format\Html\Tag::getAttributeAsText()
 * It can be useful for attrivutes like `class`.
 * 2016-05-30 From now on $attrs could be a string. It is the same as ['class' => $attrs].
 * 2020-08-22 "Port the `df_tag` function" https://github.com/justuno-com/core/issues/253
 * @used-by ju_js_x()
 * @param string $tag
 * @param string|array(string => string|string[]|int|null) $attrs [optional]
 * @param string|null|string[] $content [optional]
 * @param bool|null $multiline [optional]
 * @return string
 */
function ju_tag($tag, $attrs = [], $content = null, $multiline = null) {return Tag::render(
	$tag, is_array($attrs) ? $attrs : ['class' => $attrs], $content, $multiline
);}