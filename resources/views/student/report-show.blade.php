<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Report {{ $incident->tracking_code }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-brand-100 p-6 sm:p-8 space-y-3 text-ink">
                <p><strong>Status:</strong>
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

                    <div id="chatBox" class="space-y-2 mb-3">
                        @forelse ($messages as $m)
                            @php $mine = $m->sender_id === auth()->id(); @endphp
                            <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-md rounded-lg px-3 py-2 text-sm {{ $mine ? 'bg-brand-700 text-white' : 'bg-gray-100 text-gray-800' }}">
                                    <p class="whitespace-pre-line">{{ $m->body }}</p>
                                    <p class="text-xs opacity-70 mt-1">{{ $mine ? 'You' : 'Counselor' }} · {{ $m->created_at->format('M d, g:i A') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No messages yet. The counselor may reach out here.</p>
                        @endforelse
                    </div>

                    <form method="POST" action="{{ route('student.reports.messages', $incident) }}" class="space-y-2">
                        @csrf
                        <textarea name="body" rows="2" required maxlength="2000" placeholder="Write a message"
                                  class="block w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] shadow-sm text-sm"></textarea>
                        <x-input-error :messages="$errors->get('body')" />
                        <x-primary-button>Send</x-primary-button>
                    </form>
                </div>

                <a href="{{ route('student.reports.index') }}" class="inline-block underline text-sm text-brand-700">Back to My Reports</a>
            </div>
        </div>
    </div>

    <script>
    (function () {
        const url = "{{ route('student.reports.messages.index', $incident) }}";
        const other = 'Counselor';
        const box = document.getElementById('chatBox');
        let lastId = {{ $messages->last()?->id ?? 0 }};

        async function poll() {
            try {
                const r = await fetch(url, { headers: { 'Accept': 'application/json' } });
                const data = await r.json();
                if (data.length && data[data.length - 1].id !== lastId) {
                    lastId = data[data.length - 1].id;
                    box.innerHTML = data.map(m => `
                        <div class="flex ${m.mine ? 'justify-end' : 'justify-start'}">
                          <div class="max-w-md rounded-lg px-3 py-2 text-sm ${m.mine ? 'bg-brand-700 text-white' : 'bg-gray-100 text-gray-800'}">
                            <p class="whitespace-pre-line">${m.body.replace(/</g, '&lt;')}</p>
                            <p class="text-xs opacity-70 mt-1">${m.mine ? 'You' : other} · ${m.time}</p>
                          </div>
                        </div>`).join('');
                }
            } catch (e) {}
        }
        setInterval(poll, 5000);
    })();
    </script>
</x-app-layout>