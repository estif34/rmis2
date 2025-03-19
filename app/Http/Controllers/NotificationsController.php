<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->unreadNotifications()->paginate(10);
        
        return view('notifications.index', compact('notifications'));
    }

    
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return redirect()->back()->with('success', 'Notification marked as read');
    }
    
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return redirect()->back()->with('success', 'All notifications marked as read');
    }
}