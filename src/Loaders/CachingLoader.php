<?php
/**
 * @author Tomáš Blatný
 */

namespace PhoenixCMS\Config\Loaders;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Neon\Neon;
use PhoenixCMS\Config\FileNotFoundException;
use PhoenixCMS\Config\ILoader;
use PhoenixCMS\Utils\HashMap;


class CachingLoader implements ILoader
{

	/** @var Cache */
	private $cache;


	public function __construct(IStorage $storage)
	{
		$this->cache = new Cache($storage, 'PhoenixCMS.Config.files');
	}


	/**
	 * @param string $path
	 * @return HashMap
	 */
	public function load($path)
	{
		if (!file_exists($path)) {
			throw new FileNotFoundException("File '$path' not found.");
		}

		return HashMap::from(
			$this->cache->load($path, function (&$dependencies) use ($path) {
				$dependencies[Cache::FILES] = $path;
				return Neon::decode(file_get_contents($path));
			}),
			TRUE
		);
	}
}
