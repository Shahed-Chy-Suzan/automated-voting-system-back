<?php

namespace App\Listeners;

use App\BusDriver;
use App\Events\NotificationCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleNotificationCreatedEvent implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param NotificationCreatedEvent $event
     * @return void
     */
    public function handle(NotificationCreatedEvent $event)
    {
        $notification = $event->notification;

        $status = BusDriver::STATUS_SAFE;

        if($notification->pulse < 60 || $notification->pulse > 94 ) {
            $status = BusDriver::STATUS_MODERATE;
        }
        if($notification->temperature < 95 || $notification->temperature > 105 ) {
            $status = BusDriver::STATUS_MODERATE;
        }
        if($notification->oxygen < 93 || $notification->oxygen > 100 ) {
            $status = BusDriver::STATUS_MODERATE;
        }
        if($notification->emergency_button == 1) {
            $status = BusDriver::STATUS_DANGER;
        }
        if($notification->robery_button == 1 ) {
            $status = BusDriver::STATUS_DANGER;
        }

        BusDriver::where(['channel'=> $notification->channel])
            ->update(['status'=> $status]);
    }
}
