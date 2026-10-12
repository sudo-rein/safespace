@php
    $unread = auth()->user()->unreadNotifications()->latest()->take(5)->get();
    $count = auth()->user()->unreadNotifications()->count();
@endphp

<div class="relative" x-data="{ open: false }">
    <button @click="open = ! open" class="relative p-2 text-gray-600 hover:text-brand-700">
        <span class="text-lg">🔔</span>
        @if ($count > 0)
            <span class="absolute -top-1 -right-1 bg-brand-700 text-white text-xs rounded-full px-1.5">{{ $count }}</span>
        @endif
    </button>

    <div x-show="open" @click.outside="open = false" x-cloak
         class="absolute right-0 mt-2 w-80 bg-white border border-brand-100 rounded-xl shadow-lg z-50 overflow-hidden">
        @forelse ($unread as $n)
            <a href="{{ route('counselor.notifications.read', $n->id) }}"
               class="block px-4 py-2 text-sm border-b border-brand-50 hover:bg-brand-50 text-ink">
                @if (($n->data['level'] ?? '') === 'urgent')
                    <span class="px-2 py-0.5 rounded-full bg-gray-900 text-white text-[10px] font-semibold me-1">URGENT</span>
                @endif
                {{ $n->data['message'] }}
                <span class="block text-xs text-gray-500">{{ $n->created_at->diffForHumans() }}</span>
            </a>
        @empty
            <p class="px-4 py-3 text-sm text-gray-500">No new notifications.</p>
        @endforelse
    </div>
</div>