<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Audit Log</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <form method="GET" class="mb-4 flex gap-2">
                    <select name="action" class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] shadow-sm text-sm">
                        <option value="">All actions</option>
                        @foreach ($actions as $a)
                            <option value="{{ $a }}" @selected(request('action') === $a)>{{ str_replace('_', ' ', $a) }}</option>
                        @endforeach
                    </select>
                    <x-primary-button>Filter</x-primary-button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b border-brand-100">
                            <tr><th class="py-2">Time</th><th>User</th><th>Action</th><th>Subject</th><th>IP</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr class="border-b border-brand-50 last:border-0">
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
                </div>

                <div class="mt-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>