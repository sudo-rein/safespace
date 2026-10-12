<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">My Reports</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-brand-100 p-4 sm:p-6">
                @forelse ($incidents as $incident)
                    <a href="{{ route('student.reports.show', $incident) }}"
                       class="flex justify-between items-center py-3 px-2 border-b border-brand-50 last:border-0 rounded-lg hover:bg-brand-50">
                        <div>
                            <p class="font-semibold text-ink">{{ $incident->tracking_code }}</p>
                            <p class="text-sm text-gray-500">Submitted {{ $incident->submitted_at->format('M d, Y') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if ($incident->unread_messages > 0)
                                <span class="px-2 py-1 rounded-full bg-brand-100 text-brand-800 text-xs font-semibold">New message</span>
                            @endif
                            <span class="text-sm px-3 py-1 rounded-full bg-brand-50 text-brand-700 border border-brand-100">
                                {{ $incident->studentStatus() }}
                            </span>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-600">You haven't submitted any reports yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>