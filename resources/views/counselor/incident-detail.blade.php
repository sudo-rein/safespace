<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Report {{ $incident->tracking_code }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($incident->assessment?->urgent_flag)
                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-xl flex items-start gap-3">
                    <span class="px-2 py-0.5 rounded-full bg-gray-900 text-white text-xs font-semibold mt-0.5">URGENT</span>
                    <p class="font-bold text-red-700">Self-harm indicators found. Contact the reporter promptly.</p>
                </div>
            @endif

            {{-- Risk --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <div class="flex items-center gap-3">
                    <x-risk-badge :level="$incident->risk_level" size="sm" />
                    <span class="text-xs text-gray-500">set by {{ $incident->risk_source }}</span>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ $incident->assessment?->reason }}</p>

                @if ($matched->isNotEmpty())
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($matched as $m)
                            <span class="px-2 py-1 bg-blue-100 text-blue-900 rounded text-xs">
                                {{ $m['word'] }} <span class="text-blue-700">({{ $m['category'] }})</span>
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Change risk --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                @if (session('status'))
                    <p class="mb-3 text-sm text-green-700">{{ session('status') }}</p>
                @endif

                <p class="font-semibold mb-2 text-ink">Change risk level</p>
                <form method="POST" action="{{ route('counselor.incidents.risk', $incident) }}" class="space-y-3">
                    @csrf
                    <select name="new_risk" class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] shadow-sm text-sm">
                        @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $v => $label)
                            <option value="{{ $v }}" @selected($incident->risk_level === $v)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <textarea name="reason" rows="2" required placeholder="Reason for the change (required)"
                              class="block w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] shadow-sm text-sm">{{ old('reason') }}</textarea>
                    <x-input-error :messages="$errors->get('new_risk')" />
                    <x-input-error :messages="$errors->get('reason')" />
                    <x-primary-button>Save change</x-primary-button>
                </form>

                @if ($incident->overrides->isNotEmpty())
                    <div class="mt-4 border-t border-brand-100 pt-3 text-sm text-gray-600 space-y-1">
                        <p class="font-semibold text-ink">History</p>
                        @foreach ($incident->overrides as $o)
                            <p>
                                {{ $o->created_at->format('M d, Y g:i A') }}:
                                {{ ucfirst($o->old_risk) }} → {{ ucfirst($o->new_risk) }}
                                by {{ $o->counselor?->name }}. "{{ $o->reason }}"
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Report --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6 space-y-3 text-ink">
                <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $incident->status)) }}</p>
                <p><strong>Incident date:</strong> {{ $incident->incident_date->format('M d, Y') }}</p>
                <p><strong>Time:</strong> {{ $incident->incident_time ? \Illuminate\Support\Carbon::parse($incident->incident_time)->format('g:i A') : 'Not given' }}</p>
                <p><strong>Place:</strong> {{ $incident->location?->name }}</p>
                <p><strong>Happened before:</strong> {{ $incident->repeated ? 'Yes' : 'No' }}</p>
                <p><strong>Someone hurt:</strong> {{ $incident->someone_hurt ? 'Yes' : 'No' }}</p>
                <div>
                    <p class="font-semibold">What happened</p>
                    <p class="whitespace-pre-line">{!! $highlighted !!}</p>
                </div>
            </div>



            
            {{-- Reporter --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <p class="font-semibold text-ink">Reporter</p>
                <p>
                    {{ $incident->reporter?->name }}
                    @if ($incident->report_mode === 'confidential')
                        <span class="ms-2 px-2 py-0.5 rounded-full bg-brand-700 text-white text-xs">Confidential</span>
                    @endif
                </p>
                @if ($incident->report_mode === 'confidential')
                    <p class="text-xs text-red-700 mt-1">Do not disclose the reporter's identity to the parties involved.</p>
                @endif
            </div>

            {{-- Parties --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <p class="font-semibold mb-2 text-ink">People involved</p>
                @forelse ($incident->parties as $party)
                    <p class="text-sm">{{ $party->name_text }} <span class="text-gray-500">({{ ucfirst($party->role) }})</span></p>
                @empty
                    <p class="text-sm text-gray-500">None listed.</p>
                @endforelse
            </div>

            {{-- Evidence --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <p class="font-semibold mb-2 text-ink">Evidence</p>
                @forelse ($incident->attachments as $file)
                    <a href="{{ route('counselor.incidents.attachment', [$incident, $file]) }}" target="_blank"
                       class="block underline text-sm text-brand-700">{{ $file->original_name }}</a>
                @empty
                    <p class="text-sm text-gray-500">No files attached.</p>
                @endforelse
            </div>

            {{-- Messages --}}
           <div class="bg-white rounded-2xl border border-brand-100 p-6">
    <p class="font-semibold mb-1 text-ink">Messages with the reporter</p>
    <p class="text-xs text-red-700 mb-3">Visible only to you and the reporter. Never share it with the parties involved.</p>
    @php
        $chatMessages = $incident->messages->map(fn ($m) => [
            'id' => $m->id, 'body' => $m->body,
            'mine' => $m->sender_id !== $incident->reporter_user_id,
            'time' => $m->created_at->format('M d, g:i A'),
        ])->values();
    @endphp
    <x-chat-box :poll-url="route('counselor.incidents.messages.index', $incident)"
                :send-url="route('counselor.incidents.messages', $incident)"
                other="Reporter" :messages="$chatMessages" />
</div>






            {{-- Case --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                @if ($incident->caseFile)
                    <p class="text-sm text-gray-600 mb-2">
                        Case opened {{ $incident->caseFile->opened_at->format('M d, Y') }}
                        @if ($incident->caseFile->closed_at) (closed) @endif
                    </p>
                    <a href="{{ route('counselor.cases.show', $incident->caseFile) }}"
                       class="inline-block px-4 py-2 bg-brand-700 hover:bg-brand-600 text-white rounded-[11px] text-sm font-semibold">Go to case workspace</a>
                @else
                    <form method="POST" action="{{ route('counselor.incidents.case.open', $incident) }}">
                        @csrf
                        <x-primary-button>Open Case</x-primary-button>
                    </form>
                @endif
            </div>

            <a href="{{ route('counselor.queue') }}" class="inline-block underline text-sm text-brand-700">Back to queue</a>
        </div>
    </div>

  
</x-app-layout>