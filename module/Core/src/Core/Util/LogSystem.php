<?php

namespace Core\Util;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class LogSystem
{
    private static $instance;

    public static function getInstance( $fileName = "logs.log" )
    {
        $filePatch = "./data/log/{$fileName}";
        $fileInfo = new \SplFileInfo( $filePatch );

        if ( !$fileInfo->isFile() || !$fileInfo->isReadable() )
            file_put_contents( $filePatch , "");

        self::$instance = new Logger;
        self::$instance->addWriter( new Stream( $filePatch ) );

        return self::$instance;
    }

}
