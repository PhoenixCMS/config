<?php
/**
 * @author Tomáš Blatný
 */

use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use Nette\Neon\Neon;
use PhoenixCMS\Config\Loaders\CachingLoader;
use Tester\Assert;


require __DIR__ . '/../../../bootstrap.php';

$path = __DIR__ . '/../../../temp/';
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
Assert::same($configData, $loader->load($config));
Assert::same($configData, $cache->load($config));

/*
$configData['c'] = 'c';
file_put_contents($config, Neon::encode($configData));
$cache->clean([]); TODO fix

Assert::null($cache->load($config));
*/
