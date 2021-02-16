<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class NotificationCreatedEvent
{
    use SerializesModels;

    /**
     * @var object
     */
    public $notification;

    /**
     * Create a new event instance.
     *
     * @param object $notification
     */
    public function __construct(object $notification)
    {
        $this->notification = $notification;
    }
}
