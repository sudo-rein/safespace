<x-guest-layout>
    <div class="space-y-4 text-sm text-gray-700">
        <h1 class="text-xl font-bold text-gray-900">Privacy Notice</h1>
        <p class="text-gray-500">SafeSpace · East Central Integrated School</p>

        <h2 class="font-semibold text-gray-900">What we collect</h2>
        <p>Your LRN, name, grade level, and section when you register, and the details you enter in an incident report (date, place, people involved, description, optional evidence files).</p>

        <h2 class="font-semibold text-gray-900">Why we collect it</h2>
        <p>Only to receive, review, and manage bullying reports, as required of schools under the Anti-Bullying Act (RA 10627).</p>

        <h2 class="font-semibold text-gray-900">Who can see it</h2>
        <p>Only the guidance counselor. If you report confidentially, your name is visible to the guidance counselor only. Other students, including those named in a report, never see who reported.</p>

        <h2 class="font-semibold text-gray-900">How it is protected</h2>
        <p>Role-based access, private file storage, and an audit log that records who viewed a report. The keyword checker runs on the school's own server, and no report text is sent to outside services.</p>

        <h2 class="font-semibold text-gray-900">How long we keep it</h2>
        <p>Closed cases are kept for {{ config('safespace.retention_years') }} year(s), then reviewed for archiving or deletion.</p>

        <h2 class="font-semibold text-gray-900">Your rights</h2>
        <p>Under the Data Privacy Act (RA 10173) you may ask to see, correct, or request deletion of your data. Contact the Data Protection Officer below.</p>

        <h2 class="font-semibold text-gray-900">Data Protection Officer</h2>
        <p>{{ config('safespace.dpo_name') }}<br>{{ config('safespace.dpo_contact') }}</p>

        <a href="{{ url()->previous() }}" class="underline text-gray-600">Back</a>
    </div>
</x-guest-layout>