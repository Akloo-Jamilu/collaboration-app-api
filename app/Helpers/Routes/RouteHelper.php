<?php

namespace App\Helpers\Routes;


class RouteHelper
{
    public static function includeRouteFiles(String $folder)
    {
        $directoryIterator = new \RecursiveDirectoryIterator($folder);
        /**
         * @var \RecursiveDirectoryIterator | \RecursiveIteratorIterator $it 
         */
        $it = new \RecursiveIteratorIterator($directoryIterator);

        while ($it->valid()) {
            if (
                !$it->isDot()
                && $it->isFile()
                && $it->isReadable()
                && $it->current()->getExtension() === 'php'
            ) {
                require $it->key();
                require $it->current()->getPathname();
            }
            $it->next();
        }
    }
}
