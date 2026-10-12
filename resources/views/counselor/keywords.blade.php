<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Keyword List</h2>
    </x-slot>

    @php $field = 'border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] shadow-sm text-sm'; @endphp

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-50 border-l-4 border-green-600 p-3 text-sm text-green-800 rounded-xl">{{ session('status') }}</div>
            @endif

            {{-- Test a sentence --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <p class="font-semibold mb-2 text-ink">Test a sentence</p>
                <form method="GET" class="flex gap-2">
                    <input type="text" name="sample" value="{{ $sample }}" placeholder="Type a sentence" class="flex-1 {{ $field }}">
                    <x-primary-button>Test</x-primary-button>
                </form>
                @if ($result)
                    <div class="mt-3 text-sm">
                        <x-risk-badge :level="$result['risk']" :urgent="$result['urgent']" size="sm" />
                        <p class="text-gray-600 mt-1">{{ $result['reason'] }}</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ($result['matched_words'] as $m)
                                <span class="px-2 py-1 bg-blue-100 text-blue-900 rounded text-xs">{{ $m['word'] }} ({{ $m['category'] }})</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Add word --}}
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <p class="font-semibold mb-2 text-ink">Add a word</p>
                <form method="POST" action="{{ route('counselor.keywords.store') }}" class="flex flex-wrap gap-2">
                    @csrf
                    <select name="category_id" required class="{{ $field }}">
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ ucfirst($c->severity_group) }})</option>
                        @endforeach
                    </select>
                    <input type="text" name="word" required placeholder="word or phrase" class="{{ $field }}">
                    <x-primary-button>Add</x-primary-button>
                </form>
                <x-input-error :messages="$errors->get('word')" class="mt-2" />
            </div>

            {{-- Lists --}}
            @foreach ($categories as $c)
                <div class="bg-white rounded-2xl border border-brand-100 p-6">
                    <p class="font-semibold mb-2 text-ink">{{ $c->name }}
                        <span class="text-xs font-normal text-gray-500">({{ ucfirst($c->severity_group) }}{{ $c->is_urgent ? ', urgent' : '' }})</span>
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($c->keywords as $k)
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs {{ $k->is_active ? 'bg-brand-50 text-brand-800 border border-brand-100' : 'bg-gray-50 text-gray-400 line-through' }}">
                                {{ $k->word }}
                                <form method="POST" action="{{ route('counselor.keywords.toggle', $k) }}">@csrf
                                    <button class="underline text-[10px]">{{ $k->is_active ? 'disable' : 'enable' }}</button>
                                </form>
                                <form method="POST" action="{{ route('counselor.keywords.destroy', $k) }}"
                                      onsubmit="return confirm('Delete this word?')">@csrf @method('DELETE')
                                    <button class="text-red-600 text-[10px]">delete</button>
                                </form>
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>