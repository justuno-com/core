// 2020-08-23 "Port the `Port the Lodash library" https://github.com/justuno-com/core/issues/273
var config = {paths: {
	// 2023-08-30
	// «Refused to load the script 'https://cdn.jsdelivr.net/lodash/4.14.1/lodash.js'
	// because it violates the following Content Security Policy directive: "script-src <…>"»:
	// https://github.com/justuno-com/core/issues/403
	'ju-lodash': 'https://cdn.jsdelivr.net/lodash/4.14.1/lodash'
}};