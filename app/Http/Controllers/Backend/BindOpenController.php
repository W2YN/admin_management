<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class BindOpenController extends Controller
{
	protected $appid = '';
	protected $appsecret = '';
	protected $authorize_url = 'http://wxapp.jojin.com/api/connect/oauth2/authorize';
	protected $access_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token';
	protected $code = '';
	
    public function __construct()
    {
    	$this->appid = 'wxa3046204ca21805a';
    	$this->appsecret = '4855b2ccf6974f9748b813e871863cb0';
    }
    
    /**
     * 绑定管理员openid
     */
    public function bindOpenid(Request $request)
    {
    	if(!$request->has('code')){
    		$this->getOAuth2Code();
    	}
    	
    	$this->code = $request->input('code');
    	
    	$openid = $this->getAccessTokenOpenidOAuth2();
    	if(empty($openid)){
    		return response($this->timeoutHtml());
    	}
    	
    	$muid = $request->input('muid', false);
    	
    	if(!$res = $this->checkMuidAndOpenid($muid)){
    		return response('页面不存在', 404);
    	}
    	
    	$html = $this->generateHtml($res->name, $muid, $openid);
		
    	return response($html);
    }
	
    /**
     * 绑定操作处理
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bindOpenidHandler (Request $request)
    {
    	if($request->ajax()){
    		$ret_data = [];
    		
    		if(!$request->has('muid') || !$request->has('openid')){
    			$ret_data = ['errorCode' => -1, 'msg' => '数据不合法'];
    			return response()->json($ret_data);
    		}
			
    		$openid = $request->input('openid');
    		$muid = $request->input('muid', false);
    		
    		if(!$res = $this->checkMuidAndOpenid($muid)){
    			$ret_data = ['errorCode' => -2, 'msg' => '用户不存在'];
    			return response()->json($ret_data);
    		}
    		
    		DB::table('users')->where('id', $res->id)->update(['openid' => $openid]);
    		
    		$ret_data = ['errorCode' => 0, 'msg' => '绑定成功'];
    		return response()->json($ret_data);
    	}
    }
    
    /**
     * 授权跳转
     * @param string $scope
     * @param string $state
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
     */
	protected function getOAuth2Code ($scope='snsapi_base', $state=''){
		$redirect_uri = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		
		$url = $this->authorize_url . '?appid=' . $this->appid;
		$url .= '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=' . $scope;
		$url .= '&state=' . $state . '#wechat_redirect';
		
		header("Location: {$url}");die;
	}
	
	/**
	 * 获取openid
	 * @return Ambigous <\Symfony\Component\HttpFoundation\Response, \Illuminate\Contracts\Routing\ResponseFactory, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
	 */
	protected function getAccessTokenOpenidOAuth2 ()
	{
		if(empty($this->code)){
			return response('无法获取到code');
		}
		
		$url = $this->access_token_url . '?appid=' . $this->appid;
		$url .= '&secret=' . $this->appsecret . '&code=' . $this->code . '&grant_type=authorization_code';
		
		$res = $this->curlRequest($url);
		if(empty($res) || empty($res['openid'])){
			return false;
		}
		
		return $res['openid'];
	}
	
	/**
	 * curl请求
	 *
	 * @param string $url
	 * @param string $data
	 * @param string $decode
	 * @return mixed
	 */
	protected function curlRequest ($url, $data=null, $decode=true)
	{
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		if(!is_null($data)){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		
		$res = curl_exec($ch);
		
		curl_close($ch);
		
		if($decode){
			return json_decode($res, true);
		}
		return $res;
	}
	
	/**
	 * 生成html
	 * @return string
	 */
	protected function generateHtml ($name, $muid, $openid)
	{
		$csrf_token = csrf_token();
		$html = <<<EOT
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=no" />				
<link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.7/iconfont.css" />
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.1/layer.js"></script>
</head>								
<body>
	<center>您的用户名是{$name}</center><br/>
	<center><button class="btn btn-secondary radius bindOpenid" type="button">绑定我的微信号</button></center>							
</body>
<script type="text/javascript">
$(function (){
	$('.bindOpenid').click(function (){
		layer.confirm('真的要绑定吗？', {
			btn: ['是的','不了']
		}, function(){
			$('.bindOpenid').prop('disabled', 'disabled');
			$.ajax({
				url: '/backend/userCenter/bindOpenIDHandler',
				data: {_method: "PUT", _token: "{$csrf_token}", muid: "{$muid}", openid: "{$openid}"},
				type: 'post',
				dataType: 'json',
				success: function(data){
					if(data.errorCode == 0){
						$('.bindOpenid').parent().empty().text('绑定成功，请关闭该页面');
						layer.alert(data.msg);
					}else{
						layer.alert(data.msg);
						$('.bindOpenid').removeProp('disabled');
					}
				}
			});
		}, function(){});
	});
});
</script>
</html>
EOT;
		
		return $html;
	}
	
	/**
	 * 生成超时页面弹框
	 * @return string
	 */
	protected function timeoutHtml ()
	{
		$html = <<<EOF
<script>
alert('出问题啦，请重试...');		
</script>
EOF;
		
		return $html;		
	}
	
	/**
	 * 校验muid
	 * @param unknown $muid
	 * @return boolean
	 */
	protected function checkMuidAndOpenid ($muid)
	{
		$muid = \Crypt::decrypt($muid);
		$res = DB::table('users')->where('id', $muid)->first();
		if(empty($res) || !empty($res->openid)){
			return false;
		}
		
		return $res;
	}
	
}
