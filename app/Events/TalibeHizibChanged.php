<?php
namespace App\Events;


use App\Talibe;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TalibeHizibChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $talibe;
    public $oldHizib;
    public $newHizib;
    public $user;

    public function __construct(Talibe $talibe, $oldHizib, $newHizib, $user = null)
    {
        $this->talibe = $talibe;
        $this->oldHizib = $oldHizib;
        $this->newHizib = $newHizib;
        $this->user = $user;
    }
}

