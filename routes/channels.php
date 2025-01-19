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
Broadcast::channel('chat', function ($user) {
    return true; // Permite que todos los usuarios escuchen este canal
});

return new Channel('chat');
