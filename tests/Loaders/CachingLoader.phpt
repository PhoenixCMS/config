<?php
/**
 * @author Tomáš Blatný
 */

use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use Nette\Neon\Neon;
use PhoenixCMS\Config\Loaders\CachingLoader;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';

$path = __DIR__ . '/../temp/';
$config = $path . 'PhoenixCMS.Config.file.neon';

$storage = new FileStorage($path);
$cache = new Cache($storage, 'PhoenixCMS.Config.files');
$loader = new CachingLoader($storage);

$configData = [
	'a' => 'a',
	'b' => [
		'a',
		'b',
		'c',
	]
];

$cache->clean([Cache::ALL => TRUE]);
@unlink($config);
file_put_contents($config, Neon::encode($configData));

Assert::null($cache->load($config));
Assert::type('PhoenixCMS\Utils\HashMap', $loadedConfig = $loader->load($config));
Assert::equal($configData, $cache->load($config));

Assert::equal($configData['a'], $loadedConfig->getString('a'));
Assert::equal($configData['b'][0], $loadedConfig->getArray('b')->getString(0));

/*
$configData['c'] = 'c';
file_put_contents($config, Neon::encode($configData));

sleep(1);
clearstatcache();
$cache->clean([]); TODO fix

Assert::null($cache->load($config));
*/
