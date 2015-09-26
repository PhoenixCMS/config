<?php
/**
 * @author Tomáš Blatný
 */

namespace PhoenixCMS\Config;

interface ILoader
{

	/**
	 * @param string $path
	 * @return mixed
	 */
	function load($path);
}
