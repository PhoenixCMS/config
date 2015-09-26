<?php
/**
 * @author Tomáš Blatný
 */

namespace PhoenixCMS\Config\DI;

use Nette\DI\CompilerExtension;


class ConfigExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$this->compiler->parseServices($builder, $this->loadFromFile(__DIR__ . '/config.neon'), $this->name);
	}

}
