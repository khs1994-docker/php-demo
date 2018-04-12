<?php

namespace Example\Providers;

use Pimple\Container;
use Example\Service\AAA;
use Example\Service\BBB;
use Pimple\ServiceProviderInterface;

class BBBProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        // AAA
        $pimple['bbb.aaa'] = function ($app) {
            return new AAA($app['config']->get('a'));
        };

        // BBB 依赖 AAA，将 AAA 注入 BBB
        $pimple['bbb'] = function ($app) {
            return new BBB($app['bbb.aaa']);
        };
    }
}
