<?php

namespace App\Providers;

use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Log;
use Tools\BankCardTools;
use Tools\IdCardTools;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if( env('APP_ENV') == 'local' ){
            DB::listen(function($sql, $bindings, $time) {
                Log::info('查询日志：'. $sql . ' 参数:' .json_encode($bindings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            });
        }

        //自定义身份证校验
        Validator::extend('idNumber', function($attribute, $value, $parameters, $validator) {
            return IdCardTools::checkIdCard( $value );
        });

        //自定义银行卡校验
        Validator::extend('bankCard', function($attribute, $value, $parameters, $validator) {
            return BankCardTools::checkBankCard( $value );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
