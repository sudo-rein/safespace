<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Review Queue</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex flex-wrap gap-6 text-sm mb-4">
                    <div class="flex gap-3">
                        <span class="text-gray-500">Show:</span>
                        <a href="{{ route('counselor.queue', ['view' => 'active', 'risk' => request('risk')]) }}"
                           class="{{ request('view', 'active') === 'active' ? 'font-bold underline' : 'underline' }}">Active</a>
                        <a href="{{ route('counselor.queue', ['view' => 'closed', 'risk' => request('risk')]) }}"
                           class="{{ request('view') === 'closed' ? 'font-bold underline' : 'underline' }}">Closed</a>
                        <a href="{{ route('counselor.queue', ['view' => 'all', 'risk' => request('risk')]) }}"
                           class="{{ request('view') === 'all' ? 'font-bold underline' : 'underline' }}">All</a>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-gray-500">Risk:</span>
                        <a href="{{ route('counselor.queue', ['view' => request('view', 'active')]) }}" class="underline">Any</a>
                        <a href="{{ route('counselor.queue', ['view' => request('view', 'active'), 'risk' => 'medium']) }}" class="underline text-orange-700">Medium</a>
                        <a href="{{ route('counselor.queue', ['view' => request('view', 'active'), 'risk' => 'high']) }}" class="underline text-red-700">High</a>
                        <a href="{{ route('counselor.queue', ['view' => request('view', 'active'), 'risk' => 'low']) }}" class="underline text-yellow-700">Low</a>
                    </div>
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
                                    <a href="{{ route('counselor.incidents.show', $incident) }}" class="underline">{{ $incident->tracking_code }}</a>
                                    @if ($incident->assessment?->urgent_flag)
                                        <span class="ms-1 px-2 py-0.5 rounded-full bg-red-600 text-white text-xs">URGENT</span>
                                    @endif
                                </td>
                                <td>{{ $incident->submitted_at->format('M d, Y g:i A') }}</td>
                                <td>{{ $incident->location?->name }}</td>
                                <td><x-risk-badge :level="$incident->risk_level" /></td>
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