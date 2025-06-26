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

class TalibeDaaraChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $talibe;
    public $oldDaara;
    public $newDaara;
    public $user;

    public function __construct(Talibe $talibe, $oldDaara, $newDaara, $user = null)
    {
        $this->talibe = $talibe;
        $this->oldDaara = $oldDaara;
        $this->newDaara = $newDaara;
        $this->user = $user;
    }
}
