<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Loads
 *
 * @param string $folder
 *
 * @return void
 */
function __load($folder)
{
    foreach (scandir(dirname(__DIR__) . $folder) as $file) {
        $path = $folder . '/' . $file;
        if (is_dir(dirname(__DIR__) . $path)) {
            preg_match('/^\.\.?$/', $file, $matches);
            if (count($matches) < 1) {
                __load($path);
            }
        } else {
            if (fnmatch('*.php', $file)) {
                require_once dirname(__DIR__) . $path;
            }
        }
    }
}

__load('/lib');
__load('/controllers');
