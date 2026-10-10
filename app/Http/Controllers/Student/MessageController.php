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
                User::where('role', 'counselor')->where('is_active', true)->get(),
                new NewChatMessage($incident)
            );
        } catch (\Throwable $e) {
            report($e);
        }

        return back();
    }
}