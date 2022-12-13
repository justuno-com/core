<?php
namespace Justuno\Core\Sentry;
final class TransactionStack {
	/**
	 * 2020-06-27
	 * @used-by \Justuno\Core\Sentry\Client::__construct()
	 */
	function __construct() {$this->stack = [];}

	/**
	 * 2022-11-11
	 * @used-by \Justuno\Core\Sentry\Client::capture()
	 * @return string|null
	 */
	function peek() {
		$len = count($this->stack);
		if ($len === 0) {
			return null;
		}
		return $this->stack[$len - 1];
	}

	/**
	 * 2022-11-11
	 * @used-by \Justuno\Core\Sentry\Client::__construct()
	 */
	function push(string $c):void {$this->stack[] = $c;}
}