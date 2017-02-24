<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class SendTemplateMsg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templatemsg:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'search template msg which not send then send them parallelly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$cur_time = date('Y-m-d H:i:s');
    	$res = DB::connection('mysql_wx_official_accounts')
    				->table('wx_template_messages')
    				->where('issend', 0)
    				->where('is_delay', 1)
    				->where('opertion_time', '<', $cur_time)
    				->orderBy('id')
    				->skip(0)->take(100)
    				->get(['id']);
    	
		if( ! ($base_url = env('TEMPLATE_DELAY_SEND_URL', false)) ) return false;
    	$send_urls = [];
    	
    	if(!empty($res)){
    		foreach($res as $val){
    			$tmp_arr = [];
    			$tmp_arr['url'] = $base_url . '?id=' . $val->id;
    			$tmp_arr['post_data'] = ['id' => $val->id];
    			
    			$send_urls[] = $tmp_arr;
    		}
    		
    		$this->multi_curl_request($send_urls);
    	}
    }
    
    /**
     * parallel curl request
     * 
     * @param mixed $send_urls
     * @return boolean
     */
    protected function multi_curl_request($send_urls)
    {
    	if(empty($send_urls))
    		return false;
    	
    	$mh = curl_multi_init();
    	
    	$count = count($send_urls);
    	$t_start = microtime(true);
    	
    	foreach(array_slice($send_urls, 0, 10) as $val){
    		$ch = curl_init($val['url']);
    		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $val['post_data']);
    		curl_multi_add_handle($mh, $ch);
    	}
    	if($count > 10){
    		array_splice($send_urls, 0, 10);
    	}else{
    		$send_urls = [];
    	}
    	
    	$log_infos = [];
    	$i = $j = 0;
    	
    	$running = null;
    	do{
    		$mrc = curl_multi_exec($mh, $running);
			curl_multi_select($mh);
			
			if($mrc == CURLM_OK){
				while($mhinfo = curl_multi_info_read($mh)){
					$i++;
					$tmp_ch = $mhinfo['handle'];
					
					if(env('APP_ENV') == 'local'){
						$return_res = curl_getinfo($tmp_ch);
						$tmp_log = [
							'content' => curl_multi_getcontent($tmp_ch),
							'error' => curl_error($tmp_ch),
							'errno' => curl_errno($tmp_ch),
							'url' => $return_res['url'],
							'http_code' => $return_res['http_code'],
						];
						$log_infos[] =  $tmp_log;
					}
					
					curl_multi_remove_handle($mh, $tmp_ch);
					curl_close($tmp_ch);
						
					if(!empty($send_urls)){
						$tmp_url = array_shift($send_urls);
							
						$ch = curl_init($tmp_url['url']);
						curl_setopt($ch, CURLOPT_TIMEOUT, 10);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $tmp_url['post_data']);
						curl_multi_add_handle($mh, $ch);
						$j++;
					}
				}
			}
    	}while($running > 0);
		
    	curl_multi_close($mh);
    	
    	$t_end = microtime(true);
    	$usage_time = $t_end - $t_start;
    	
    	if(env('APP_ENV') == 'local'){
    		\Log::info('发送模板消息的curl请求:' . json_encode($log_infos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL . $i . ':' . $usage_time . ':added:' . $j);
    	}
    }
    
    
    
}
