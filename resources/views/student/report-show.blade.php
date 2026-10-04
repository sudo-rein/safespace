<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report {{ $incident->tracking_code }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-3 text-gray-800">
                <p><strong>Status:</strong> {{ $incident->studentStatus() }}</p>
                <p><strong>Date of incident:</strong> {{ $incident->incident_date->format('M d, Y') }}</p>
                <p><strong>Place:</strong> {{ $incident->location?->name }}</p>
                <p><strong>Reported as:</strong> {{ $incident->report_mode === 'confidential' ? 'Confidential' : 'Named' }}</p>
                <div>
                    <p class="font-semibold">What you reported</p>
                    <p class="whitespace-pre-line">{{ $incident->description }}</p>
                </div>
                <a href="{{ route('student.reports.index') }}" class="inline-block underline text-sm text-gray-600">Back to My Reports</a>
            </div>
        </div>
    </div>
</x-app-layout>