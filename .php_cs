<?php

#
# $ composer global require friendsofphp/php-cs-fixer
#
# $ php-cs-fixer.phar fix
#
# @link https://github.com/FriendsOfPHP/PHP-CS-Fixer

$finder = PhpCsFixer\Finder::create()
    //->exclude('somedir')
    // ->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php')
    ->in(__DIR__)
    ->ignoreVCS(true);
;

return PhpCsFixer\Config::create()
    ->setRules([
      '@Symfony' => true,
      'full_opening_tag' => false,
    ])
    ->setCacheFile(__DIR__.'/.php_cs.cache')
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;
