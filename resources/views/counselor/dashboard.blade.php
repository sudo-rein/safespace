<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Guidance Dashboard</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Urgent banner --}}
            @if ($urgent->isNotEmpty())
                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-xl">
                    <p class="font-bold text-red-700">URGENT: self-harm indicators in {{ $urgent->count() }} report(s)</p>
                    <ul class="mt-2 text-sm text-red-800 space-y-1">
                        @foreach ($urgent as $incident)
                            <li>
                                <a href="{{ route('counselor.incidents.show', $incident) }}" class="underline font-semibold">{{ $incident->tracking_code }}</a>,
                                submitted {{ $incident->submitted_at->diffForHumans() }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white rounded-2xl border border-brand-100 p-4">
                    <p class="text-sm text-gray-500">New</p>
                    <p class="text-2xl font-extrabold text-brand-700">{{ $stats['new'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-brand-100 p-4">
                    <p class="text-sm text-gray-500">Low</p>
                    <p class="text-2xl font-extrabold text-yellow-600">{{ $stats['low'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-brand-100 p-4">
                    <p class="text-sm text-gray-500">Medium</p>
                    <p class="text-2xl font-extrabold text-orange-600">{{ $stats['medium'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-brand-100 p-4">
                    <p class="text-sm text-gray-500">High</p>
                    <p class="text-2xl font-extrabold text-red-600">{{ $stats['high'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-brand-100 p-4 col-span-2 md:col-span-1">
                    <p class="text-sm text-gray-500">Open cases</p>
                    <p class="text-2xl font-extrabold text-brand-700">{{ $stats['open_cases'] }}</p>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-brand-100 p-4">
                    <p class="text-sm font-semibold mb-2 text-ink">Reports per month</p>
                    <canvas id="monthlyChart"></canvas>
                </div>
                <div class="bg-white rounded-2xl border border-brand-100 p-4">
                    <p class="text-sm font-semibold mb-2 text-ink">Top locations</p>
                    <canvas id="locationChart"></canvas>
                </div>
                <div class="bg-white rounded-2xl border border-brand-100 p-4">
                    <p class="text-sm font-semibold mb-2 text-ink">Risk split</p>
                    <canvas id="riskChart"></canvas>
                </div>
            </div>

            {{-- Recent Reports --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold text-ink">Recent reports</h3>
                    <a href="{{ route('counselor.queue') }}" class="underline text-sm text-brand-700 hover:text-brand-500">Open review queue</a>
                </div>

                @forelse ($recent as $incident)
                    <div class="flex justify-between items-center py-2 border-b border-brand-50 last:border-0 text-sm">
                        <div>
                            <a href="{{ route('counselor.incidents.show', $incident) }}" class="font-semibold underline text-brand-700">{{ $incident->tracking_code }}</a>
                            <span class="text-gray-500 ms-2">{{ $incident->location?->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-risk-badge :level="$incident->risk_level" :urgent="(bool) $incident->assessment?->urgent_flag" />
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-sm">No reports yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const c = @json($charts);
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: { labels: c.monthly.labels, datasets: [{ label: 'Reports', data: c.monthly.data, backgroundColor: '#6b1a28', borderRadius: 6 }] },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
        new Chart(document.getElementById('locationChart'), {
            type: 'bar',
            data: { labels: c.locations.labels, datasets: [{ label: 'Reports', data: c.locations.data, backgroundColor: '#a23449', borderRadius: 6 }] },
            options: { indexAxis: 'y', plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
        new Chart(document.getElementById('riskChart'), {
            type: 'doughnut',
            data: { labels: ['Low', 'Medium', 'High'], datasets: [{ data: c.risk, backgroundColor: ['#facc15', '#f97316', '#dc2626'] }] }
        });
    });
    </script>
</x-app-layout>