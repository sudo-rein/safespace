<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Review Queue</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex gap-3 text-sm mb-4">
                    <a href="{{ route('counselor.queue') }}" class="underline">All</a>
                    <a href="{{ route('counselor.queue', ['risk' => 'medium_high']) }}" class="underline text-red-700">Medium to High</a>
                    <a href="{{ route('counselor.queue', ['risk' => 'low']) }}" class="underline text-green-700">Low</a>
                </div>

                <table class="w-full text-sm text-left">
                    <thead class="text-gray-500 border-b">
                        <tr>
                            <th class="py-2">Code</th>
                            <th>Submitted</th>
                            <th>Place</th>
                            <th>Risk</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($incidents as $incident)
                            <tr class="border-b last:border-0 {{ $incident->assessment?->urgent_flag ? 'bg-red-50' : '' }}">
                                <td class="py-2 font-semibold">
                                    {{ $incident->tracking_code }}
                                    @if ($incident->assessment?->urgent_flag)
                                        <span class="ms-1 px-2 py-0.5 rounded-full bg-red-600 text-white text-xs">URGENT</span>
                                    @endif
                                </td>
                                <td>{{ $incident->submitted_at->format('M d, Y g:i A') }}</td>
                                <td>{{ $incident->location?->name }}</td>
                                <td>
                                    <span class="px-2 py-1 rounded-full text-xs
                                        {{ $incident->risk_level === 'medium_high' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $incident->risk_level === 'medium_high' ? 'Medium to High' : 'Low' }}
                                    </span>
                                </td>
                                <td>{{ ucfirst(str_replace('_', ' ', $incident->status)) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-4 text-gray-600">No reports found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>