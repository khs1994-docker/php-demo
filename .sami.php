<?php

/**
*  @link https://github.com/FriendsOfPHP/Sami
*
*  $ curl -fsSL http://get.sensiolabs.org/sami.phar /usr/local/bin/sami
*  $ chmod +x /usr/local/bin/sami
*
*  $ sami update .sami.php
*  $ cd build ; php -S 0.0.0.0:8080
*
*/

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('public')
    ->exclude('tests')
    ->exclude('example')
    ->in(__DIR__)
;

return new Sami($iterator);
