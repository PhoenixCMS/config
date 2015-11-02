<?php
/**
 * @author Tomáš Blatný
 */

namespace PhoenixCMS\Config;

use PhoenixCMS\Utils\HashMap;


interface ILoader
{

	/**
	 * @param string $path
	 * @return HashMap
	 */
	function load($path);
}
