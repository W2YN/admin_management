<?php

namespace App\Listeners\Log;

use App\Events\Log\ActionLogged;
use App\Events\Log\OperationEvent;
use App\Services\ActionLogService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OperationEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OperationEvent  $event
     * @return void
     */
    public function handle(OperationEvent $event)
    {
        //
        ActionLogService::updateOperationLog($event->getDesc());
    }
}
