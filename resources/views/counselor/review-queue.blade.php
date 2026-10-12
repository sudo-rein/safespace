<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Review Queue</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-brand-100 p-6">

                <div class="flex flex-wrap gap-6 text-sm mb-4">
                    <div class="flex gap-3 items-center">
                        <span class="text-gray-500">Show:</span>
                        @foreach (['active' => 'Active', 'closed' => 'Closed', 'all' => 'All'] as $v => $label)
                            <a href="{{ route('counselor.queue', ['view' => $v, 'risk' => request('risk')]) }}"
                               class="px-3 py-1 rounded-full {{ request('view', 'active') === $v ? 'bg-brand-700 text-white' : 'text-brand-700 hover:bg-brand-50' }}">{{ $label }}</a>
                        @endforeach
                    </div>
                    <div class="flex gap-3 items-center">
                        <span class="text-gray-500">Risk:</span>
                        <a href="{{ route('counselor.queue', ['view' => request('view', 'active')]) }}" class="text-brand-700 underline">Any</a>
                        <a href="{{ route('counselor.queue', ['view' => request('view', 'active'), 'risk' => 'low']) }}" class="underline text-yellow-700">Low</a>
                        <a href="{{ route('counselor.queue', ['view' => request('view', 'active'), 'risk' => 'medium']) }}" class="underline text-orange-700">Medium</a>
                        <a href="{{ route('counselor.queue', ['view' => request('view', 'active'), 'risk' => 'high']) }}" class="underline text-red-700">High</a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b border-brand-100">
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
                                <tr class="border-b border-brand-50 last:border-0 {{ $incident->assessment?->urgent_flag ? 'bg-brand-50' : '' }}">
                                    <td class="py-2 font-semibold">
                                        <a href="{{ route('counselor.incidents.show', $incident) }}" class="underline text-brand-700">{{ $incident->tracking_code }}</a>
                                        @if ($incident->assessment?->urgent_flag)
                                            <span class="ms-1 px-2 py-0.5 rounded-full bg-gray-900 text-white text-xs">URGENT</span>
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
    </div>
</x-app-layout>