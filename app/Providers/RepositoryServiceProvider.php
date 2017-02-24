<?php

namespace App\Providers;


use App\Repositories\MessageRepository;
use App\Repositories\Contract\ContractInstallmentRepository;
use App\Repositories\Contract\ContractRepository;
use App\Repositories\FreezeLogRepository;
use App\Repositories\ActionLoggerRepository;
use App\Repositories\Rbcx\RbcxCardInfoRepository;
use App\Repositories\Rbcx\RbcxOrderRepository;
use App\Repositories\Sms\SmsRepository;
use App\Repositories\UserRepository;
use App\Repositories\MenuRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ActionRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\WaterPurifier\BankCardsRepository;
use App\Repositories\WaterPurifier\DeviceRepository;
use App\Repositories\WaterPurifier\InstallmentRepository;
use App\Repositories\WaterPurifier\MaintainRepository;
use App\Repositories\WaterPurifier\ChannelRepository;
use App\Repositories\WaterPurifierRepository;
use App\Repositories\WaterSaleRepository;
use App\Repositories\WxActivityStatRepository;
use App\Repositories\WxPlatform\WxEventRepository;
use App\Repositories\WxPlatform\WxMenuRepository;
use App\Repositories\WxPlatform\WxMessageRepository;
use App\Repositories\WxPlatform\WxNoticeRepository;
use App\Repositories\WxPlatform\WxTemplateMessageRepository;
use App\Repositories\WxPlatform\WxTemplateRepository;
use App\Repositories\WxPlatform\WxUserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CarInsurance\OrderRepository;
use App\Repositories\Financial\ContractRepository as FinancialContractRepository;
use App\Repositories\Financial\ExpressRepository;
use App\Repositories\Financial\UserRepository as FinancialUserRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 合并自定义配置文件
        $configuration = realpath(__DIR__ . '/../../config/repository.php');
        $this->mergeConfigFrom($configuration, 'repository');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMenuRepository();
        $this->registerUserRepository();
        $this->registerRoleRepository();
        $this->registerActionRepository();
        $this->registerPermissionRepository();

        $this->registerOtherRepository();

        $this->registerContractRepository();
        $this->registerCarInsuranceRepository();
        $this->registerMaintainRepository();
        $this->registerSmsRepository();

        $this->registerRbcxRepository();
        $this->registerWxPlatformRepository();
        $this->registerFinancialRepository();
    }

    public function registerWxPlatformRepository()
    {
        $this->app->singleton(WxMessageRepository::$accessor, function ($app) {
            $modelName = config('repository.models.wxplatform.message');
            $model = new $modelName();
            $validator = $app['validator'];
            return new WxMessageRepository($model, $validator);
        });
        $this->app->singleton(WxEventRepository::$accessor, function ($app) {
            $modelName = config('repository.models.wxplatform.event');
            $model = new $modelName();
            $validator = $app['validator'];
            return new WxEventRepository($model, $validator);
        });
        $this->app->singleton(WxUserRepository::$accessor, function ($app) {
            $modelName = config('repository.models.wxplatform.user');
            $model = new $modelName();
            $validator = $app['validator'];
            return new WxUserRepository($model, $validator);
        });
        $this->app->singleton(WxNoticeRepository::$accessor, function ($app) {
            $modelName = config('repository.models.wxplatform.notice');
            $model = new $modelName();
            $validator = $app['validator'];
            return new WxNoticeRepository($model, $validator);
        });
        $this->app->singleton(WxTemplateRepository::$accessor, function ($app) {
            $modelName = config('repository.models.wxplatform.template');
            $model = new $modelName();
            $validator = $app['validator'];
            return new WxTemplateRepository($model, $validator);
        });
        $this->app->singleton(WxTemplateMessageRepository::$accessor, function ($app) {
            $modelName = config('repository.models.wxplatform.templatemessage');
            $model = new $modelName();
            $validator = $app['validator'];
            return new WxTemplateMessageRepository($model, $validator);
        });

        $this->app->singleton(WxMenuRepository::$accessor, function ($app) {
            $modelName = config('repository.models.wxplatform.menu');
            $model = new $modelName();
            $validator = $app['validator'];
            return new WxMenuRepository($model, $validator);
        });
    }

    public function registerRbcxRepository()
    {
        $this->app->singleton(RbcxOrderRepository::$accessor, function ($app) {
            $modelName = config('repository.models.rbcx.order');
            $model = new $modelName();
            $validator = $app['validator'];
            return new RbcxOrderRepository($model, $validator);
        });
        $this->app->singleton(RbcxCardInfoRepository::$accessor, function ($app) {
            $modelName = config('repository.models.rbcx.cardinfo');
            $model = new $modelName();
            $validator = $app['validator'];
            return new RbcxCardInfoRepository($model, $validator);
        });

    }

    public function registerSmsRepository()
    {
        $this->app->singleton(SmsRepository::$accessor, function ($app) {
            $modelName = config('repository.models.sms.sms');
            $model = new $modelName();
            $validator = $app['validator'];
            return new SmsRepository($model, $validator);
        });
    }
    
    public function registerFinancialRepository()
    {
    	$this->app->singleton(FinancialContractRepository::$accessor, function ($app) {
    		$modelName = config('repository.models.financial.contract');
    		$model = new $modelName();
    		$validator = $app['validator'];
    		return new FinancialContractRepository($model, $validator);
    	});
    	
        $this->app->singleton(ExpressRepository::$accessor, function ($app) {
    		$modelName = config('repository.models.financial.express');
    		$model = new $modelName();
    		$validator = $app['validator'];
    		return new ExpressRepository($model, $validator);
    	});
    		
    	$this->app->singleton(FinancialUserRepository::$accessor, function ($app) {
    	    $modelName = config('repository.models.financial.user');
    		$model = new $modelName();
    	    $validator = $app['validator'];
    		return new FinancialUserRepository($model, $validator);
    	});
    }
    
    public function registerMaintainRepository()
    {
        $this->app->singleton(ActionLoggerRepository::$accessor, function ($app) {
            $modelName = config('repository.models.actionLogger');
            $model = new $modelName();
            $validator = $app['validator'];
            return new ActionLoggerRepository($model, $validator);
        });
        $this->app->singleton(MessageRepository::$accessor, function ($app) {
            $modelName = config('repository.models.message');
            $model = new $modelName();
            $validator = $app['validator'];
            return new MessageRepository($model, $validator);
        });
    }

    public function registerCarInsuranceRepository()
    {
        $this->app->singleton(OrderRepository::$accessor, function ($app) {
            $modelName = config('repository.models.carInsurance.order');
            $model = new $modelName();
            $validator = $app['validator'];
            return new OrderRepository($model, $validator);
        });
    }

    //注册合同管理相关服务
    public function registerContractRepository()
    {
        $this->app->singleton(ContractRepository::$accessor, function ($app) {
            $modelName = config('repository.models.contract.contract');
            $model = new $modelName();
            $validator = $app['validator'];
            return new ContractRepository($model, $validator);
        });

        $this->app->singleton(ContractInstallmentRepository::$accessor, function ($app) {
            $modelName = config('repository.models.contract.contractInstallment');
            $model = new $modelName();
            $validator = $app['validator'];
            return new ContractInstallmentRepository($model, $validator);
        });

    }

    public function registerOtherRepository()
    {
        $this->app->singleton(FreezeLogRepository::$accessor, function ($app) {
            $modelName = config('repository.models.freezeLog');
            $model = new $modelName();
            $validator = $app['validator'];

            return new FreezeLogRepository($model, $validator);
        });

        $this->app->singleton(WaterSaleRepository::$accessor, function ($app) {
            $modelName = config('repository.models.waterSale');
            $model = new $modelName();
            $validator = $app['validator'];

            return new WaterSaleRepository($model, $validator);
        });

        $this->app->singleton(WaterPurifierRepository::$accessor, function ($app) {
            $modelName = config('repository.models.waterPurifier');
            $model = new $modelName();
            $validator = $app['validator'];

            return new WaterPurifierRepository($model, $validator);
        });

        $this->app->singleton(BankCardsRepository::$accessor, function ($app) {
            $modelName = config('repository.models.bankCard');
            $model = new $modelName();
            $validator = $app['validator'];
            return new BankCardsRepository($model, $validator);
        });

        $this->app->singleton(InstallmentRepository::$accessor, function ($app) {
            $modelName = config('repository.models.installment');
            $model = new $modelName();
            $validator = $app['validator'];
            return new InstallmentRepository($model, $validator);
        });

        $this->app->singleton(DeviceRepository::$accessor, function ($app) {
            $modelName = config('repository.models.device');
            $model = new $modelName();
            $validator = $app['validator'];
            return new DeviceRepository($model, $validator);
        });

        $this->app->singleton(MaintainRepository::$accessor, function ($app) {
            $modelName = config('repository.models.maintain');
            $model = new $modelName();
            $validator = $app['validator'];
            return new MaintainRepository($model, $validator);
        });

        $this->app->singleton(ChannelRepository::$accessor, function ($app) {
        	$modelName = config('repository.models.channel');
        	$model = new $modelName();
        	$validator = $app['validator'];
        	return new ChannelRepository($model, $validator);
        });
        	
        $this->app->singleton(WxActivityStatRepository::$accessor, function ($app) {
            $modelName = config('repository.models.wxActivityStat');
            $model = new $modelName();
            $validator = $app['validator'];
            return new WxActivityStatRepository($model, $validator);
        });

    }

    /**
     * Register the Menu Repository
     *
     * @return mixed
     */
    public function registerMenuRepository()
    {
        $this->app->singleton('menurepository', function ($app) {
            $model = config('repository.models.menu');
            $menu = new $model();
            $validator = $app['validator'];

            return new MenuRepository($menu, $validator);
        });
    }

    public function registerUserRepository()
    {
        $this->app->singleton('userrepository', function ($app) {
            $model = config('repository.models.user');
            $user = new $model();
            $validator = $app['validator'];

            return new UserRepository($user, $validator);
        });
    }

    public function registerRoleRepository()
    {
        $this->app->singleton('rolerepository', function ($app) {
            $model = config('repository.models.role');
            $role = new $model();
            $validator = $app['validator'];

            return new RoleRepository($role, $validator);
        });
    }

    public function registerActionRepository()
    {
        $this->app->singleton('actionrepository', function ($app) {
            $model = config('repository.models.action');
            $action = new $model();
            $validator = $app['validator'];

            return new ActionRepository($action, $validator);
        });
    }

    public function registerPermissionRepository()
    {
        $this->app->singleton('permissionrepository', function ($app) {
            $model = config('repository.models.permission');
            $permission = new $model();
            $validator = $app['validator'];

            return new PermissionRepository($permission, $validator);
        });
    }
}
