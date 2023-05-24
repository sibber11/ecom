<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
public function readNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
