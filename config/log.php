<?php
/**
 * Created by PhpStorm.
 * User: hangaoyu
 * Date: 16/12/22
 * Time: 下午2:44
 */
return [
    'userlog'=>env('USER_LOG', 'yes'),
    'userlog_path'=>env('USER_LOG_PATH', storage_path().'/logs/test.log'),
];