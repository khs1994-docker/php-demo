<?php

// First Edit config

const GITURL = 'https://github.com';
const GITUSERNAME = 'khs1994-php';
const GITREPO = 'example';
const STYLECIID = 115306597;

if ($fh = opendir(__DIR__)) {
    while (false !== ($file = readdir($fh))) {
        if ('.' === $file or '..' === $file or is_dir($file) or '.khsci.php' === $file) {
            continue;
        }
        // echo $file.PHP_EOL;
        $content = file_get_contents($file);
        $content = str_replace('{{ EXAMPLE_GITURL_EXAMPLE }}', GITURL, $content);
        $content = str_replace('{{ EXAMPLE_GITUSERNAME_EXAMPLE }}', GITUSERNAME, $content);
        $content = str_replace('{{ EXAMPLE_GITREPO_EXAMPLE }}', GITREPO, $content);
        $content = str_replace('{{ EXAMPLE_STYLECIID_EXAMPLE }}', STYLECIID, $content);
        file_put_contents($file, $content);
    }
    closedir($fh);
}
