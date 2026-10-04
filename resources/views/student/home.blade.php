<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Student Home</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
                Welcome, {{ auth()->user()->name }}.
                <a href="{{ route('student.report.create') }}"
                   class="inline-block mt-4 px-4 py-2 bg-gray-800 text-white rounded-md text-sm">
                    Report an Incident
                </a>
                <a href="{{ route('student.reports.index') }}"
                   class="inline-block mt-4 ml-4 px-4 py-2 bg-gray-800 text-white rounded-md text-sm">
                    My Reports
                </a>
            </div>
        </div>
    </div>
</x-app-layout>