<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Incident $incident): RedirectResponse
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:2000'],
        ]);

        $incident->messages()->create([
            'sender_id' => $request->user()->id,
            'body' => $data['body'],
        ]);

        AuditLogger::log('sent_message', $incident);

        return back()->with('status', 'Message sent.');
    }

    public function index(Incident $incident)
{
    $incident->messages()
        ->where('sender_id', $incident->reporter_user_id)
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    return response()->json(
        $incident->messages()->get()->map(fn ($m) => [
            'id' => $m->id,
            'body' => $m->body,
            'mine' => $m->sender_id !== $incident->reporter_user_id,
            'time' => $m->created_at->format('M d, g:i A'),
        ])
    );
}
}