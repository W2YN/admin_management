<?php
/**
 * Created by PhpStorm.
 * User: hangaoyu
 * Date: 16/12/22
 * Time: 下午2:35
 */
namespace App\Services;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Config;

class LogService {

    public static function debug($log,$logpath)
    {
        self::write($log,Logger::DEBUG,$logpath);
    }
    public static function info($log,$logpath)
    {
        self::write($log,Logger::INFO,$logpath);
    }
    public static function notice($log,$logpath)
    {
        self::write($log,Logger::NOTICE,$logpath);
    }
    public static function warning($log,$logpath)
    {
        self::write($log,Logger::WARNING,$logpath);
    }
    public static function error($log,$logpath)
    {
        self::write($log,Logger::ERROR,$logpath);
    }
    public static function critical($log,$logpath)
    {
        self::write($log,Logger::CRITICAL,$logpath);
    }
    public static function alert($log,$logpath)
    {
        self::write($log,Logger::ALERT,$logpath);
    }
    public static function emergency($log,$logpath)
    {
        self::write($log,Logger::EMERGENCY,$logpath);
    }

    private static function write($logtext='',$level=Logger::INFO,$logpath)
    {
        if ("yes"==Config::get('log.userlog'))
        {
            $log = new Logger('log');
            $handler = new RotatingFileHandler($logpath, 0, $level);
            $handler->setFormatter(new LineFormatter("[%datetime%] %channel%.%level_name%: %message% \n"));
            $log->pushHandler($handler);
            $log->addInfo($logtext);
        }
    }
}