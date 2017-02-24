<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 13:39
 */

namespace App\Repositories\Sms;


use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;
use Illuminate\Http\Request;

class SmsRepository extends CommonRepository
{
    public static $accessor = 'sms_repository';

    /**
     *
     * @return SmsRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

    public function checkMobiles( $mobiles )
    {
        if( !is_array( $mobiles ) ){
            throw new \Exception("\$mobiles格式不合法");
        }
        $data = [];
        foreach( $mobiles as $mobile ){
            if ( preg_match('/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/i', $mobile) == 0 ) {
                throw new \Exception("手机号码不合法:{$mobile}");
            }
            $data[] = $mobile;
        }
        if( count($data) > 32 ){
            throw new \Exception("最多支持32个手机号吗:{$mobile}");
        }
        return $data;
    }
    
    public function sendSms( $mobiles, $content, $opertion_time='', $user_id=0 )
    {
        if( $opertion_time == '' ){
            $opertion_time = date( 'Y-m-d H:i:s' );
        }
        SmsRepository::getInstance()->create([
            'content'=>$content,
            'mobiles'=>implode(',',$mobiles),
            'opertion_time'=>date( 'Y-m-d H:i:s', $opertion_time ),
            'user_id'=>$user_id
        ]);
    }

    public function smsList ($limit, $request){
    	if(!empty($request->mobiles)){
    		return $this->model->where('mobiles', 'like', "%{$request->mobiles}%")->paginate($limit);
    	}
    	return $this->paginate($limit);
    }

    
}