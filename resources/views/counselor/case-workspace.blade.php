<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Case {{ $case->incident->tracking_code }}
        </h2>
    </x-slot>

    @php $closed = $case->closed_at !== null; @endphp

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border-l-4 border-green-600 p-3 text-sm text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-600 p-3 text-sm text-red-800 rounded">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Summary + status --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800">
                        {{ ucfirst(str_replace('_', ' ', $case->incident->status)) }}
                    </span>
                    <x-risk-badge :level="$case->incident->risk_level" size="sm" />
                    <span class="text-sm text-gray-500">Opened {{ $case->opened_at->format('M d, Y') }}</span>
                    <a href="{{ route('counselor.incidents.show', $case->incident) }}" class="underline text-sm text-gray-600">View report</a>
                </div>

                @unless ($closed)
                    <form method="POST" action="{{ route('counselor.cases.status', $case) }}" class="mt-4 flex items-center gap-2">
                        @csrf
                        <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                            @foreach (['case_opened' => 'Case Opened', 'intervention' => 'Intervention', 'monitoring' => 'Monitoring', 'resolved' => 'Resolved'] as $value => $label)
                                <option value="{{ $value }}" @selected($case->incident->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-primary-button>Update status</x-primary-button>
                    </form>
                @endunless
            </div>

            {{-- Notes --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="font-semibold mb-1">Case notes <span class="text-xs text-gray-500">(counselor only)</span></p>
                <p class="text-xs text-red-700 mb-3">Do not write the reporter's name in notes that may be shared.</p>

                @unless ($closed)
                    <form method="POST" action="{{ route('counselor.cases.notes', $case) }}" class="space-y-2 mb-4">
                        @csrf
                        <textarea name="note" rows="3" required placeholder="Write a note"
                                  class="block w-full border-gray-300 rounded-md shadow-sm text-sm"></textarea>
                        <x-primary-button>Add note</x-primary-button>
                    </form>
                @endunless

                @forelse ($case->notes as $note)
                    <div class="border-t py-2 text-sm">
                        <p class="text-gray-500 text-xs">{{ $note->created_at->format('M d, Y g:i A') }} · {{ $note->counselor?->name }}</p>
                        <p class="whitespace-pre-line">{{ $note->note }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No notes yet.</p>
                @endforelse
            </div>

            {{-- Interventions --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="font-semibold mb-3">Interventions</p>

                @unless ($closed)
                    <form method="POST" action="{{ route('counselor.cases.interventions', $case) }}" class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-4">
                        @csrf
                        <select name="type" required class="border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="counseling">Counseling</option>
                            <option value="parent_conference">Parent conference</option>
                            <option value="mediation">Mediation</option>
                            <option value="referral">Referral</option>
                            <option value="other">Other</option>
                        </select>
                        <input type="date" name="intervention_date" value="{{ now()->toDateString() }}"
                               max="{{ now()->toDateString() }}" required class="border-gray-300 rounded-md shadow-sm text-sm">
                        <input type="text" name="remarks" placeholder="Remarks (optional)"
                               class="border-gray-300 rounded-md shadow-sm text-sm">
                        <div class="sm:col-span-3"><x-primary-button>Log intervention</x-primary-button></div>
                    </form>
                @endunless

                @forelse ($case->interventions as $i)
                    <p class="border-t py-2 text-sm">
                        <strong>{{ ucfirst(str_replace('_', ' ', $i->type)) }}</strong>
                        <span class="text-gray-500">· {{ $i->intervention_date->format('M d, Y') }}</span>
                        @if ($i->remarks) <br>{{ $i->remarks }} @endif
                    </p>
                @empty
                    <p class="text-sm text-gray-500">No interventions logged.</p>
                @endforelse
            </div>

            {{-- Follow-ups --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="font-semibold mb-3">Follow-ups</p>

                @unless ($closed)
                    <form method="POST" action="{{ route('counselor.cases.followups', $case) }}" class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-4">
                        @csrf
                        <input type="date" name="due_date" min="{{ now()->toDateString() }}" required
                               class="border-gray-300 rounded-md shadow-sm text-sm">
                        <input type="text" name="remarks" placeholder="What to check (optional)"
                               class="sm:col-span-2 border-gray-300 rounded-md shadow-sm text-sm">
                        <div class="sm:col-span-3"><x-primary-button>Schedule follow-up</x-primary-button></div>
                    </form>
                @endunless

                @forelse ($case->followUps as $f)
                    <div class="border-t py-2 text-sm flex justify-between items-center">
                        <div>
                            <strong>{{ $f->due_date->format('M d, Y') }}</strong>
                            @if ($f->remarks) <span class="text-gray-600">· {{ $f->remarks }}</span> @endif
                            @if (! $f->done_at && $f->due_date->isPast() && ! $f->due_date->isToday())
                                <span class="ms-2 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs">Overdue</span>
                            @endif
                        </div>
                        @if ($f->done_at)
                            <span class="text-green-700 text-xs">Done {{ $f->done_at->format('M d') }}</span>
                        @else
                            <form method="POST" action="{{ route('counselor.cases.followups.done', [$case, $f->id]) }}">
                                @csrf
                                <button class="underline text-xs text-gray-700">Mark done</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No follow-ups scheduled.</p>
                @endforelse
            </div>

            {{-- Close case --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($closed)
                    <p class="font-semibold">Case closed {{ $case->closed_at->format('M d, Y') }}</p>
                    <p class="text-sm whitespace-pre-line mt-1">{{ $case->outcome }}</p>
                @else
                    <p class="font-semibold mb-2">Close case</p>
                    <form method="POST" action="{{ route('counselor.cases.close', $case) }}" class="space-y-2">
                        @csrf
                        <textarea name="outcome" rows="2" required placeholder="Outcome (required)"
                                  class="block w-full border-gray-300 rounded-md shadow-sm text-sm"></textarea>
                        <x-primary-button>Close case</x-primary-button>
                    </form>
                @endif
            </div>

            <a href="{{ route('counselor.queue') }}" class="inline-block underline text-sm text-gray-600">Back to queue</a>
        </div>
    </div>
</x-app-layout>