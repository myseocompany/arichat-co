<?php 

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\Models\User;

class MessageService
{
    public function saveImage(&$photo, &$mediaUrl)
    {   
        Log::info('Guardando la foto:', [$photo]);
        $fileName = $photo->store('photos', 'public');

        $mediaUrl = Storage::url($fileName);
        

        $photo = null;
    }

    
}
