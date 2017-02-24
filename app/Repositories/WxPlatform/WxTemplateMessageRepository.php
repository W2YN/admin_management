<?php

namespace App\Repositories\WxPlatform;

use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;


class WxTemplateMessageRepository extends CommonRepository
{
    public static $accessor = 'wxtemplate_message_repository';

    /**
     *
     * @return WxUserRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }


   

}
