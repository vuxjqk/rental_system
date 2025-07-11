<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $receiverId = null)
    {
        try {
            if ($receiverId) {
                // Tải tin nhắn với một người cụ thể (cho AJAX)
                $receiver = User::whereIn('role', ['landlord', 'tenant'])
                    ->where('id', $receiverId)
                    ->where('is_active', true)
                    ->firstOrFail();

                $messages = Message::where(function ($query) use ($receiverId) {
                    $query->where('sender_id', Auth::id())
                        ->where('receiver_id', $receiverId);
                })->orWhere(function ($query) use ($receiverId) {
                    $query->where('sender_id', $receiverId)
                        ->where('receiver_id', Auth::id());
                })->orderBy('created_at', 'asc')
                    ->get();

                return view('messages.partials.message_list', [
                    'messages' => $messages,
                    'receiver' => $receiver,
                    'currentUser' => Auth::user()
                ]);
            }

            // Tải danh sách tin nhắn gần đây (cho sidebar)
            $search = $request->query('search');
            $query = Message::query()
                ->where(function ($q) {
                    $q->where('sender_id', Auth::id())
                        ->orWhere('receiver_id', Auth::id());
                })
                ->with(['sender', 'receiver'])
                ->latest();

            if ($search) {
                $query->whereHas('sender', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('receiver', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }

            $messages = $query->get()
                ->groupBy(function ($message) {
                    return $message->sender_id == Auth::id() ? $message->receiver_id : $message->sender_id;
                })
                ->map(function ($group) {
                    return $group->first();
                })
                ->sortByDesc('created_at')
                ->values();

            $perPage = 10;
            $currentPage = $request->query('page', 1);
            $messages = new \Illuminate\Pagination\LengthAwarePaginator(
                $messages->forPage($currentPage, $perPage),
                $messages->count(),
                $perPage,
                $currentPage,
                ['path' => route('messages.index')]
            );

            return view('messages.index', [
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không thể tải tin nhắn: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Không thể tải danh sách tin nhắn: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }

    public function markAsRead(Request $request, $receiverId)
    {
        try {
            Message::where('receiver_id', Auth::id())
                ->where('sender_id', $receiverId)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json([
                'status' => 'success',
                'message' => 'Đã đánh dấu các tin nhắn là đã đọc'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể đánh dấu tin nhắn: ' . $e->getMessage()
            ], 500);
        }
    }
}
