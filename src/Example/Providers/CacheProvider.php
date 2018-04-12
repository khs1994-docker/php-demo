<?php

namespace Example\Providers;

use Pimple\Container;
use Doctrine\Common\Cache\Cache;
use Pimple\ServiceProviderInterface;
use Doctrine\Common\Cache\FilesystemCache;

class CacheProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['cache'] = function () {
            return new FilesystemCache(sys_get_temp_dir());
        };
    }
}
