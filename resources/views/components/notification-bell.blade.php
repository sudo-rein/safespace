@php
    $unread = auth()->user()->unreadNotifications()->latest()->take(5)->get();
    $count = auth()->user()->unreadNotifications()->count();
@endphp

<div class="relative" x-data="{ open: false }">
    <button @click="open = ! open" class="relative p-2 text-gray-600 hover:text-gray-900">
        <span class="text-lg">🔔</span>
        @if ($count > 0)
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1.5">{{ $count }}</span>
        @endif
    </button>

    <div x-show="open" @click.outside="open = false" x-cloak
         class="absolute right-0 mt-2 w-72 bg-white border rounded-md shadow-lg z-50">
        @forelse ($unread as $n)
            <a href="{{ route('counselor.notifications.read', $n->id) }}"
               class="block px-4 py-2 text-sm border-b hover:bg-gray-50
               {{ ($n->data['level'] ?? '') === 'urgent' ? 'text-red-700 font-semibold' : 'text-gray-800' }}">
                {{ $n->data['message'] }}
                <span class="block text-xs text-gray-500">{{ $n->created_at->diffForHumans() }}</span>
            </a>
        @empty
            <p class="px-4 py-3 text-sm text-gray-500">No new notifications.</p>
        @endforelse
    </div>
</div>