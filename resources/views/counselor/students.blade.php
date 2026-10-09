<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" class="mb-4 flex gap-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or LRN"
                           class="border-gray-300 rounded-md shadow-sm text-sm w-64">
                    <x-primary-button>Search</x-primary-button>
                </form>

                <table class="w-full text-sm text-left">
                    <thead class="text-gray-500 border-b">
                        <tr><th class="py-2">Name</th><th>LRN</th><th>Registered</th><th>Last login</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $s)
                            <tr class="border-b last:border-0">
                                <td class="py-2">{{ $s->name }}</td>
                                <td>{{ $s->lrn }}</td>
                                <td>{{ $s->registered_at?->format('M d, Y') }}</td>
                                <td>{{ $s->last_login_at?->diffForHumans() ?? 'Never' }}</td>
                                <td><a href="{{ route('counselor.students.export', $s) }}" class="underline">Export data</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-4 text-gray-600">No students found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>