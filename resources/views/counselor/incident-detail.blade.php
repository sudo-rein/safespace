<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report {{ $incident->tracking_code }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($incident->assessment?->urgent_flag)
                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded">
                    <p class="font-bold text-red-700">URGENT: self-harm indicators found. Contact the reporter promptly.</p>
                </div>
            @endif

            {{-- Risk --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-sm
                        {{ $incident->risk_level === 'medium_high' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ $incident->risk_level === 'medium_high' ? 'Medium to High Risk' : 'Low Risk' }}
                    </span>
                    <span class="text-xs text-gray-500">set by {{ $incident->risk_source }}</span>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ $incident->assessment?->reason }}</p>

                @if ($matched->isNotEmpty())
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($matched as $m)
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-900 rounded text-xs">
                                {{ $m['word'] }} <span class="text-gray-500">({{ $m['category'] }})</span>
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Report --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-3 text-gray-800">
                <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $incident->status)) }}</p>
                <p><strong>Incident date:</strong> {{ $incident->incident_date->format('M d, Y') }}</p>
                <p><strong>Place:</strong> {{ $incident->location?->name }}</p>
                <p><strong>Happened before:</strong> {{ $incident->repeated ? 'Yes' : 'No' }}</p>
                <p><strong>Someone hurt:</strong> {{ $incident->someone_hurt ? 'Yes' : 'No' }}</p>
                <div>
                    <p class="font-semibold">What happened</p>
                    <p class="whitespace-pre-line">{!! $highlighted !!}</p>
                </div>
            </div>

            {{-- Reporter --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="font-semibold">Reporter</p>
                <p>
                    {{ $incident->reporter?->name }}
                    @if ($incident->report_mode === 'confidential')
                        <span class="ms-2 px-2 py-0.5 rounded-full bg-gray-800 text-white text-xs">Confidential</span>
                    @endif
                </p>
                @if ($incident->report_mode === 'confidential')
                    <p class="text-xs text-red-700 mt-1">Do not disclose the reporter's identity to the parties involved.</p>
                @endif
            </div>

            {{-- Parties --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="font-semibold mb-2">People involved</p>
                @forelse ($incident->parties as $party)
                    <p class="text-sm">{{ $party->name_text }} <span class="text-gray-500">({{ ucfirst($party->role) }})</span></p>
                @empty
                    <p class="text-sm text-gray-500">None listed.</p>
                @endforelse
            </div>

            {{-- Evidence --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="font-semibold mb-2">Evidence</p>
                @forelse ($incident->attachments as $file)
                    <a href="{{ route('counselor.incidents.attachment', [$incident, $file]) }}" target="_blank"
                       class="block underline text-sm">{{ $file->original_name }}</a>
                @empty
                    <p class="text-sm text-gray-500">No files attached.</p>
                @endforelse
            </div>

            <a href="{{ route('counselor.queue') }}" class="inline-block underline text-sm text-gray-600">Back to queue</a>
        </div>
    </div>
</x-app-layout>