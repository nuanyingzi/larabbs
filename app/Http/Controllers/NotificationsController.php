<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 获取当前用户的所有通知
        $notifications = Auth::user()->notifications()->paginate(10);
        // 标记所有通知为已读
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
