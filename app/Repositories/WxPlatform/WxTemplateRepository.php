<?php

namespace App\Repositories\WxPlatform;

use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;


class WxTemplateRepository extends CommonRepository
{
    public static $accessor = 'wxtemplate_repository';

    /**
     *
     * @return WxUserRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }


    public function synchronize()
    {
        $url = config('wechat.synchronize.template');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $result =json_encode(['result'=>'ok']);
        return $result;
    }


}
