<?php
namespace App\Events;


use App\Talibe;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DieuwCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dieuw;
    public $user;

    public function __construct($dieuw, $user = null)
    {
        $this->dieuw = $dieuw;
        $this->user = $user;
    }
}
