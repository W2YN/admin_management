<?php

namespace App\Console\Commands;

use App\Repositories\Rbcx\RbcxCardInfoRepository;
use Illuminate\Console\Command;

/**
 * 临时人保车险导出
 * Class RbcxExprot
 * @package App\Console\Commands
 */
class RbcxExprot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbcx:exprot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'renaochexian Exprot';

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
        //
        RbcxCardInfoRepository::getInstance()->exportExcell();
    }
}
