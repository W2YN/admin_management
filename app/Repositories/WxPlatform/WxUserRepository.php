<?php

namespace App\Repositories\WxPlatform;

use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;


class WxUserRepository extends CommonRepository
{
    public static $accessor = 'wxuser_repository';

    /**
     *
     * @return WxUserRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }


   

}
