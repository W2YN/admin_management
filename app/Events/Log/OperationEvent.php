<?php

namespace App\Events\Log;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OperationEvent extends Event
{
    use SerializesModels;

    private $desc = '';
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($desc)
    {
        //
        $this->desc = $desc;
    }

    public function getDesc()
    {
        return $this->desc;
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
