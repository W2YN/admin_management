<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/4
 * Time: 13:34
 */

namespace App\Http\Controllers\Api;


use App\Facades\TokenRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Sms\SmsRepository;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function send( Request $request )
    {
        $mobiles = trim($request->get('mobiles',''));
        $content = trim($request->get('content',''));
        $opertion_time = trim($request->get('opertion_time',''));
        $user_id = intval($request->get('user_id',0));
        $mobiles = explode( ',', $mobiles );
        
        try{
            $mobiles = SmsRepository::getInstance()->checkMobiles( $mobiles );
            if( $content == '' ){
                throw new \Exception('信息内容不能为空');
            }
            if( $user_id < 0 ){
                throw new \Exception('用户ID异常');
            }
            $opertion_time = strtotime( $opertion_time );
            if( $opertion_time === false ){
                throw new \Exception('发送时间格式不正确');
            }
            SmsRepository::getInstance()->sendSms( $mobiles, $content, $opertion_time, $user_id );
        }
        catch ( \Exception $e ){
            return $this->responseJson(['code'=>400,'message'=>$e->getMessage()],400);
        }

        return $this->responseJson(['code'=>'200'],200);
    }

    public function test( Request $request )
    {
        //return "xxxxxxxx";
        $params = $request->all();
        //var_dump( $params );
        //exit;
        return $params;
    }

}