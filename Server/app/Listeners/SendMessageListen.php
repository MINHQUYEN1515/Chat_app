<?php

namespace App\Listeners;

use App\Events\SendMessage;
use App\Helper\Helper;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PHPUnit\TextUI\Help;

class SendMessageListen
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendMessage $event)
    {
        Log::info($event->message);
        return Helper::SuccessWithData($event);
    }
}
