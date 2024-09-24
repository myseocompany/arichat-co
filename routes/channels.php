<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Broadcasting\Channel;

/*
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
*/

/*
Broadcast::channel('chat', function () {
    //
});
*/

return new Channel('chat');
