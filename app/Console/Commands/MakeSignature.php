<?php

namespace App\Console\Commands;

use App\Repositories\Rbcx\RbcxCardInfoRepository;
use Illuminate\Console\Command;

class MakeSignature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbcx:signature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $signatures = RbcxCardInfoRepository::getInstance()->all();
        collect($signatures)->map(function ($card) {
            if (empty($card->signature)) {
                return;
            }
            for ($i = 1; $i < 6; $i++) {
                RbcxCardInfoRepository::getInstance()->makeSignature($card->id, $i);
            }
        });
    }
}
