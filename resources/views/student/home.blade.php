<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-brand-700 leading-tight">Student Home</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="rounded-2xl bg-gradient-to-br from-brand-800 via-brand-700 to-brand-600 text-white p-8 shadow-sm">
                <p class="text-xs uppercase tracking-widest text-brand-200 font-semibold">Welcome back</p>
                <h3 class="mt-2 text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Hi, {{ auth()->user()->name }}. Your voice matters.
                </h3>
                <p class="mt-2 text-brand-100 max-w-xl text-sm leading-relaxed">
                    If something is bothering you at school, you can report it here. You can choose to keep your name confidential.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('student.report.create') }}"
                       class="inline-flex items-center px-5 py-2.5 rounded-[11px] bg-white text-brand-800 text-sm font-semibold shadow-sm hover:bg-brand-50 transition">
                        Report an incident
                    </a>
                    <a href="{{ route('student.reports.index') }}"
                       class="inline-flex items-center px-5 py-2.5 rounded-[11px] border border-white/40 text-white text-sm font-semibold hover:bg-white/10 transition">
                        My reports
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-brand-100 p-5">
                    <p class="font-semibold text-ink">Confidential</p>
                    <p class="mt-1 text-sm text-gray-600">Only the guidance counselor can see your name if you choose Confidential.</p>
                </div>
                <div class="bg-white rounded-2xl border border-brand-100 p-5">
                    <p class="font-semibold text-ink">Track your report</p>
                    <p class="mt-1 text-sm text-gray-600">See the status in My Reports and message the counselor about it.</p>
                </div>
                <div class="bg-white rounded-2xl border border-brand-100 p-5">
                    <p class="font-semibold text-ink">Ask SafeBot</p>
                    <p class="mt-1 text-sm text-gray-600">Use the chat button at the bottom right for quick answers.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>