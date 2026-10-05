<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Counselor Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Urgent banner --}}
            @if ($urgent->isNotEmpty())
                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded">
                    <p class="font-bold text-red-700">URGENT: self-harm indicators in {{ $urgent->count() }} report(s)</p>
                    <ul class="mt-2 text-sm text-red-800">
                        @foreach ($urgent as $incident)
                            <li>{{ $incident->tracking_code }}, submitted {{ $incident->submitted_at->diffForHumans() }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">New</p>
                    <p class="text-2xl font-bold">{{ $stats['new'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Medium to High</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['medium_high'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Low</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['low'] }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Open cases</p>
                    <p class="text-2xl font-bold">{{ $stats['open_cases'] }}</p>
                </div>
            </div>

            {{-- Recent --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold text-gray-800">Recent reports</h3>
                    <a href="{{ route('counselor.queue') }}" class="underline text-sm text-gray-600">Open review queue</a>
                </div>
                @forelse ($recent as $incident)
                    <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
                        <div>
                            <span class="font-semibold">{{ $incident->tracking_code }}</span>
                            <span class="text-gray-500 ms-2">{{ $incident->location?->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            @if ($incident->assessment?->urgent_flag)
                                <span class="px-2 py-1 rounded-full bg-red-600 text-white text-xs">URGENT</span>
                            @endif
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $incident->risk_level === 'medium_high' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ $incident->risk_level === 'medium_high' ? 'Medium to High' : 'Low' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-sm">No reports yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>