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
}