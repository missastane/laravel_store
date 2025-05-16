<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function readAll()
    {
        $notifications = Notification::where('read_at', null)->get();

        foreach($notifications as $notification)
        {
            $notification->update(['read_at' => date('Y-m-d H:i:s')]);
        }
    }
}
