<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Report {{ $incident->tracking_code }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-brand-100 p-6 sm:p-8 space-y-3 text-ink">
                
                @php
    $steps = ['Received', 'Being Reviewed', 'In Progress', 'Resolved'];
    $cur = array_search($incident->studentStatus(), $steps);
@endphp
<div class="flex items-center gap-2 text-xs sm:text-sm">
    @foreach ($steps as $i => $s)
        <div class="flex items-center gap-2 {{ $i <= $cur ? 'text-brand-700 font-semibold' : 'text-gray-400' }}">
            <span class="grid place-items-center w-6 h-6 rounded-full {{ $i <= $cur ? 'bg-brand-700 text-white' : 'bg-gray-200 text-gray-500' }}">{{ $i + 1 }}</span>
            <span>{{ $s }}</span>
        </div>
        @if (! $loop->last) <span class="flex-1 h-px {{ $i < $cur ? 'bg-brand-700' : 'bg-gray-200' }}"></span> @endif
    @endforeach
</div>
                    <span class="ms-1 text-sm px-3 py-1 rounded-full bg-brand-50 text-brand-700 border border-brand-100">{{ $incident->studentStatus() }}</span>
                </p>
                <p><strong>Date of incident:</strong> {{ $incident->incident_date->format('M d, Y') }}</p>
                <p><strong>Place:</strong> {{ $incident->location?->name }}</p>
                <p><strong>Reported as:</strong> {{ $incident->report_mode === 'confidential' ? 'Confidential' : 'Named' }}</p>
                <div>
                    <p class="font-semibold">What you reported</p>
                    <p class="whitespace-pre-line text-gray-700">{{ $incident->description }}</p>
                </div>

                <div class="border-t border-brand-100 pt-4">
                    <p class="font-semibold mb-2">Messages with the guidance counselor</p>

                   <div class="border-t border-brand-100 pt-4">
    <p class="font-semibold mb-2">Messages with the guidance counselor</p>
    @php
        $chatMessages = $messages->map(fn ($m) => [
            'id' => $m->id, 'body' => $m->body,
            'mine' => $m->sender_id === auth()->id(),
            'time' => $m->created_at->format('M d, g:i A'),
        ])->values();
    @endphp
    <x-chat-box :poll-url="route('student.reports.messages.index', $incident)"
                :send-url="route('student.reports.messages', $incident)"
                other="Counselor" :messages="$chatMessages" />
</div>

                <a href="{{ route('student.reports.index') }}" class="inline-block underline text-sm text-brand-700">Back to My Reports</a>
            </div>
        </div>
    </div>

 
</x-app-layout>