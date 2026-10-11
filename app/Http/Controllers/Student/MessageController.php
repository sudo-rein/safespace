<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\NewChatMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{
    public function store(Request $request, Incident $incident): RedirectResponse
    {
        Gate::authorize('view', $incident);

        $data = $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:2000'],
        ]);

        $incident->messages()->create([
            'sender_id' => $request->user()->id,
            'body' => $data['body'],
        ]);

        try {
            Notification::send(
                User::where('role', 'counselor')
                    ->where('is_active', true)
                    ->get(),
                new NewChatMessage($incident)
            );
        } catch (\Throwable $e) {
            report($e);
        }

        return back();
    }

    public function index(Incident $incident)
    {
        Gate::authorize('view', $incident);

        $incident->messages()
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(
            $incident->messages()
                ->get()
                ->map(fn ($m) => [
                    'id' => $m->id,
                    'body' => $m->body,
                    'mine' => $m->sender_id === auth()->id(),
                    'time' => $m->created_at->format('M d, g:i A'),
                ])
        );
    }
}

