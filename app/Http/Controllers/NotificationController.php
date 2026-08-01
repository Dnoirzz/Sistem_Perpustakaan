<?php

namespace App\Http\Controllers;

use App\Models\NotificationCustom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Ambil feed notifikasi terbaru & jumlah unread untuk user aktif
     */
    public function feed(Request $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'unread_count' => 0,
                'notifications' => [],
            ]);
        }

        $unreadCount = NotificationCustom::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        $notifications = NotificationCustom::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'message' => $item->message,
                    'url' => $item->url,
                    'type' => $item->type ?? 'info',
                    'is_read' => (bool)$item->is_read,
                    'time_ago' => $item->created_at ? $item->created_at->diffForHumans() : '',
                    'created_at' => $item->created_at ? $item->created_at->format('d/m/Y H:i') : '',
                ];
            });

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Tandai notifikasi spesifik sebagai dibaca (via GET) lalu redirect ke URL tujuan
     */
    public function open(Request $request, $id)
    {
        $userId = Auth::id();

        $notification = NotificationCustom::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($notification) {
            $notification->update(['is_read' => true]);
            $targetUrl = $notification->url ?: route('notifications.index');
        } else {
            $targetUrl = route('notifications.index');
        }

        return redirect($targetUrl);
    }

    /**
     * Tandai notifikasi spesifik sebagai dibaca (via POST)
     */
    public function markAsRead(Request $request, $id)
    {
        $userId = Auth::id();

        $notification = NotificationCustom::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($notification) {
            $notification->update(['is_read' => true]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'url' => $notification->url,
                ]);
            }

            if ($notification->url) {
                return redirect($notification->url);
            }
        }

        return redirect()->back();
    }

    /**
     * Tandai seluruh notifikasi user sebagai dibaca
     */
    public function markAllRead(Request $request)
    {
        $userId = Auth::id();

        if ($userId) {
            NotificationCustom::where('user_id', $userId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Seluruh pemberitahuan telah ditandai sebagai dibaca.');
    }

    /**
     * Halaman penuh daftar seluruh pemberitahuan user
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $notifications = NotificationCustom::where('user_id', $userId)
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Hapus satu notifikasi
     */
    public function destroy(Request $request, $id)
    {
        $userId = Auth::id();

        $notification = NotificationCustom::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($notification) {
            $notification->delete();
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Pemberitahuan berhasil dihapus.');
    }
}
