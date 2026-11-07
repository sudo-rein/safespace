<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Reports</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-brand-100 p-6">
                <p class="font-semibold mb-3 text-ink">Periodic summary (PDF)</p>
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
    <div class="bg-white rounded-2xl border border-brand-100 p-6 mt-6">
    <p class="font-semibold mb-3 text-ink">Report list (PDF or Excel)</p>
    <form method="GET" action="{{ route('counselor.reports.list') }}" class="space-y-3">
        <div class="grid grid-cols-2 gap-3">
            <div><x-input-label for="lf" value="From (optional)" /><x-text-input id="lf" type="date" name="from" class="block mt-1 w-full" /></div>
            <div><x-input-label for="lt" value="To (optional)" /><x-text-input id="lt" type="date" name="to" class="block mt-1 w-full" /></div>
        </div>
        <div>
            <x-input-label for="lr" value="Risk level (optional)" />
            <select id="lr" name="risk" class="block mt-1 w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-[11px] shadow-sm text-sm">
                <option value="">All</option><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button name="format" value="pdf" class="px-4 py-2.5 bg-brand-700 hover:bg-brand-600 text-white rounded-[11px] text-sm font-semibold">Download PDF</button>
            <button name="format" value="csv" class="px-4 py-2.5 border border-brand-700 text-brand-700 hover:bg-brand-50 rounded-[11px] text-sm font-semibold">Download Excel</button>
        </div>
    </form>
    <p class="text-xs text-gray-500 mt-3">No reporter names or report text.</p>
</div>
</x-app-layout>