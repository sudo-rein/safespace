<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="font-semibold mb-3">Periodic summary (PDF)</p>
                <form method="GET" action="{{ route('counselor.reports.periodic') }}" class="space-y-3">
                    <div>
                        <x-input-label for="from" value="From" />
                        <x-text-input id="from" type="date" name="from" class="block mt-1 w-full" required />
                    </div>
                    <div>
                        <x-input-label for="to" value="To" />
                        <x-text-input id="to" type="date" name="to" class="block mt-1 w-full" required />
                    </div>
                    <x-input-error :messages="$errors->get('to')" />
                    <x-primary-button>Download PDF</x-primary-button>
                </form>
                <p class="text-xs text-gray-500 mt-3">Counts only. No names or report text.</p>
            </div>
        </div>
    </div>
</x-app-layout>