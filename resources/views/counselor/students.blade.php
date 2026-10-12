<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Students</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <form method="GET" class="mb-4 flex gap-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or LRN"
                           class="border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] shadow-sm text-sm w-64">
                    <x-primary-button>Search</x-primary-button>
                </form>

                @if (session('status'))
                    <div class="mb-3 bg-green-50 border-l-4 border-green-600 p-3 text-sm text-green-800 rounded-xl">{{ session('status') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b border-brand-100">
                            <tr><th class="py-2">Name</th><th>LRN</th><th>Registered</th><th>Last login</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $s)
                                <tr class="border-b border-brand-50 last:border-0">
                                    <td class="py-2">
                                        {{ $s->name }}
                                        @unless ($s->is_active)
                                            <span class="ms-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs">Deactivated</span>
                                        @endunless
                                    </td>
                                    <td>{{ $s->lrn }}</td>
                                    <td>{{ $s->registered_at?->format('M d, Y') }}</td>
                                    <td>{{ $s->last_login_at?->diffForHumans() ?? 'Never' }}</td>
                                    <td>
                                        <div class="flex flex-wrap items-center gap-3 py-2">
                                            <a href="{{ route('counselor.students.export', $s) }}" class="underline text-brand-700">Export</a>
                                            <form method="POST" action="{{ route('counselor.students.reset', $s) }}" onsubmit="return confirm('Reset password?')">@csrf
                                                <button class="underline text-brand-700">Reset password</button></form>
                                            <form method="POST" action="{{ route('counselor.students.toggle', $s) }}">@csrf
                                                <button class="underline text-brand-700">{{ $s->is_active ? 'Deactivate' : 'Activate' }}</button></form>
                                            <form method="POST" action="{{ route('counselor.students.destroy', $s) }}" onsubmit="return confirm('Remove this account and its reports?')">@csrf @method('DELETE')
                                                <button class="text-red-600 underline">Remove</button></form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-4 text-gray-600">No students found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>