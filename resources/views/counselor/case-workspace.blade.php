<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Case {{ $case->incident->tracking_code }}</h2>
    </x-slot>

    @php
        $closed = $case->closed_at !== null;
        $field = 'border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] shadow-sm text-sm';
    @endphp

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border-l-4 border-green-600 p-3 text-sm text-green-800 rounded-xl">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-600 p-3 text-sm text-red-800 rounded-xl">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Summary + status --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-sm bg-brand-50 text-brand-700 border border-brand-100">
                        {{ ucfirst(str_replace('_', ' ', $case->incident->status)) }}
                    </span>
                    <x-risk-badge :level="$case->incident->risk_level" size="sm" />
                    <span class="text-sm text-gray-500">Opened {{ $case->opened_at->format('M d, Y') }}</span>
                    <a href="{{ route('counselor.incidents.show', $case->incident) }}" class="underline text-sm text-brand-700">View report</a>
                    <a href="{{ route('counselor.cases.pdf', $case) }}" class="underline text-sm text-brand-700">Download PDF</a>
                </div>

                @unless ($closed)
                    <form method="POST" action="{{ route('counselor.cases.status', $case) }}" class="mt-4 flex items-center gap-2">
                        @csrf
                        <select name="status" class="{{ $field }}">
                            @foreach (['case_opened' => 'Case Opened', 'intervention' => 'Intervention', 'monitoring' => 'Monitoring', 'resolved' => 'Resolved'] as $value => $label)
                                <option value="{{ $value }}" @selected($case->incident->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-primary-button>Update status</x-primary-button>
                    </form>
                @endunless
            </div>

            {{-- Notes --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <p class="font-semibold mb-1 text-ink">Case notes <span class="text-xs font-normal text-gray-500">(counselor only)</span></p>
                <p class="text-xs text-red-700 mb-3">Do not write the reporter's name in notes that may be shared.</p>

                @unless ($closed)
                    <form method="POST" action="{{ route('counselor.cases.notes', $case) }}" class="space-y-2 mb-4">
                        @csrf
                        <textarea name="note" rows="3" required placeholder="Write a note" class="block w-full {{ $field }}"></textarea>
                        <x-primary-button>Add note</x-primary-button>
                    </form>
                @endunless

                @forelse ($case->notes as $note)
                    <div class="border-t border-brand-100 py-2 text-sm">
                        <p class="text-gray-500 text-xs">{{ $note->created_at->format('M d, Y g:i A') }} · {{ $note->counselor?->name }}</p>
                        <p class="whitespace-pre-line">{{ $note->note }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No notes yet.</p>
                @endforelse
            </div>

            {{-- Interventions --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <p class="font-semibold mb-3 text-ink">Interventions</p>

                @unless ($closed)
                    <form method="POST" action="{{ route('counselor.cases.interventions', $case) }}" class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-4">
                        @csrf
                        <select name="type" required class="{{ $field }}">
                            <option value="counseling">Counseling</option>
                            <option value="parent_conference">Parent conference</option>
                            <option value="mediation">Mediation</option>
                            <option value="referral">Referral</option>
                            <option value="other">Other</option>
                        </select>
                        <input type="date" name="intervention_date" value="{{ now()->toDateString() }}"
                               max="{{ now()->toDateString() }}" required class="{{ $field }}">
                        <input type="text" name="remarks" placeholder="Remarks (optional)" class="{{ $field }}">
                        <div class="sm:col-span-3"><x-primary-button>Log intervention</x-primary-button></div>
                    </form>
                @endunless

                @forelse ($case->interventions as $i)
                    <p class="border-t border-brand-100 py-2 text-sm">
                        <strong>{{ ucfirst(str_replace('_', ' ', $i->type)) }}</strong>
                        <span class="text-gray-500">· {{ $i->intervention_date->format('M d, Y') }}</span>
                        @if ($i->remarks) <br>{{ $i->remarks }} @endif
                    </p>
                @empty
                    <p class="text-sm text-gray-500">No interventions logged.</p>
                @endforelse
            </div>

            {{-- Follow-ups --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <p class="font-semibold mb-3 text-ink">Follow-ups</p>

                @unless ($closed)
                    <form method="POST" action="{{ route('counselor.cases.followups', $case) }}" class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-4">
                        @csrf
                        <input type="date" name="due_date" min="{{ now()->toDateString() }}" required class="{{ $field }}">
                        <input type="text" name="remarks" placeholder="What to check (optional)" class="sm:col-span-2 {{ $field }}">
                        <div class="sm:col-span-3"><x-primary-button>Schedule follow-up</x-primary-button></div>
                    </form>
                @endunless

                @forelse ($case->followUps as $f)
                    <div class="border-t border-brand-100 py-2 text-sm flex justify-between items-center">
                        <div>
                            <strong>{{