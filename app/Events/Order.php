<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Order implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;

    public $message;

    public $branch;

    public $amount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $amount, $branch)
    {
       $this->name = $name;
       $this->amount = $amount;
       $this->branch = $branch;

       $this->message  = "{$amount} Pesanan dari {$name}";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['product-order'.$this->branch];
    }
}
