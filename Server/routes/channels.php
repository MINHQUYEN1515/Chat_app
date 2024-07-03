<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('send-chat', function ($user, $id) {
    return Auth::check();
});
