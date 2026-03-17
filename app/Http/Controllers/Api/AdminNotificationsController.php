<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class AdminNotificationsController extends Controller
{
    public function index(Request $request)
    {
        $rows = AdminNotification::query()
            ->orderByRaw('read_at is null desc')
            ->latest()
            ->paginate(15);

        return response()->json($rows);
    }

    public function markRead($id)
    {
        $n = AdminNotification::findOrFail($id);
        if (!$n->read_at) {
            $n->read_at = now();
            $n->save();
        }
        return response()->json($n);
    }

    public function markAllRead()
    {
        AdminNotification::query()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'OK']);
    }
}

