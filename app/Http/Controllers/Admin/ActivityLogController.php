<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $logs = ActivityLog::with('user.role')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('activity', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(25);

        return view('admin.activity-logs.index', [
            'logs' => $logs,
            'search' => $search,
        ]);
    }
}
