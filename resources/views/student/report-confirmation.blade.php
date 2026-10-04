<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report Submitted</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8 text-center">
                <p class="text-gray-700">Thank you for speaking up. A guidance counselor will review your report.</p>
                <p class="mt-6 text-sm text-gray-500">Your reference number</p>
                <p class="text-3xl font-bold tracking-wider text-gray-900">{{ $incident->tracking_code }}</p>
                <a href="{{ route('student.home') }}" class="inline-block mt-8 underline text-sm text-gray-600">Back to home</a>
            </div>
        </div>
    </div>
</x-app-layout>