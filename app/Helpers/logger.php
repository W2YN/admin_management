<?php
//对于log参数的获取帮助函数

if( !function_exists("action_logger_params")){
    function action_logger_params(Illuminate\Http\Request $request) {
        $method = $request->getMethod();
        //$params = [];
        //if($method=='GET') {
            $params = $request->all();
        //} else {
//            $params = $request->request->all();
//            $params = $request->getFo
//        }
        //todo 添加PUT,DELETE,OPTIONS等的分支
        $url = $request->getBaseUrl(). $request->getPathInfo();
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);
        return ['url' => $url, 'method'=>$method, 'params'=>$params];
    }
}
