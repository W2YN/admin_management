<?php
if ( ! function_exists('startsWith')) {
    function startsWith($haystack, $needle)
    {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}

if ( ! function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle,
                $temp) !== false);
    }
}
if(!function_exists('uuid')) {
    function guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }
}

if ( ! function_exists('gt_encode')) {
	function gt_encode ($val, $get_decode=false)
	{
		if(strlen($val) == 0){
			return false;
		}
	
		$key = md5('chromeandmoz');
	
		if($get_decode){ //解密
			$first_str = substr($val, 5, 1);
			$last_str = substr($val, 11, strlen($val)-11-5);
			$encode_real_val = $first_str . $last_str;
	
			$tmp_decode = base64_decode($encode_real_val);
			$decode_real_val = $tmp_decode ^ $key;
	
			return $decode_real_val;
		}else{ //加密
			$random = '1234567890abcdefghijklmnopqrstuvwxyz';
			$tmp_random = str_shuffle($random);
			$joint1 = substr($tmp_random, 0, 5);
			$joint2 = substr($tmp_random, 5, 5);
			$joint3 = substr($tmp_random, 10, 5);
	
			$encode_str = str_replace('=', '', base64_encode($val ^ $key));
	
			$first_str = substr($encode_str, 0, 1);
			$last_str = substr($encode_str, 1, (strlen($encode_str)-1));
	
			$encode_str = $joint1 . $first_str . $joint2 . $last_str . $joint3;
	
			return $encode_str;
		}
	}
}

if(! function_exists('unescaped_json_encode')) {
    function unescaped_json_encode($data){
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}






