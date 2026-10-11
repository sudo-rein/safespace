<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Audit Log</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" class="mb-4 flex gap-2">
                    <select name="action" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All actions</option>
                        @foreach ($actions as $a)
                            <option value="{{ $a }}" @selected(request('action') === $a)>{{ str_replace('_', ' ', $a) }}</option>
                        @endforeach
                    </select>
                    <x-primary-button>Filter</x-primary-button>
                </form>

                <table class="w-full text-sm text-left">
                    <thead class="text-gray-500 border-b">
                        <tr><th class="py-2">Time</th><th>User</th><th>Action</th><th>Subject</th><th>IP</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr class="border-b last:border-0">
                                <td class="py-2">{{ $log->created_at->format('M d, Y g:i A') }}</td>
                                <td>{{ $log->user?->name ?? 'System' }}</td>
                                <td>{{ str_replace('_', ' ', $log->action) }}</td>
                                <td>{{ $log->subject_type }} {{ $log->subject_id ? '#'.$log->subject_id : '' }}</td>
                                <td>{{ $log->ip_address }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-4 text-gray-600">No entries.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>