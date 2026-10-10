<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Reports</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @forelse ($incidents as $incident)
                    <a href="{{ route('student.reports.show', $incident) }}"
                       class="flex justify-between items-center py-3 border-b last:border-0 hover:bg-gray-50">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $incident->tracking_code }}</p>
                            <p class="text-sm text-gray-500">Submitted {{ $incident->submitted_at->format('M d, Y') }}</p>
                        </div>
                        @if ($incident->unread_messages > 0)
    <span class="ms-2 px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs">New message</span>
@endif
                        <span class="text-sm px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                            {{ $incident->studentStatus() }}
                        </span>
                    </a>
                @empty
                    <p class="text-gray-600">You haven't submitted any reports yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
