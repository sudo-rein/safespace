<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report an Incident</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('student.report.store') }}" enctype="multipart/form-data"
                  class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">
                @csrf

                {{-- Reporting mode --}}
                <div>
                    <p class="font-medium text-gray-800">How do you want to report?</p>
                    <label class="flex items-start mt-2">
                        <input type="radio" name="report_mode" value="confidential" class="mt-1"
                               @checked(old('report_mode', 'confidential') === 'confidential')>
                        <span class="ms-2 text-sm text-gray-700">
                            <strong>Confidential</strong>: only the guidance counselor will see my name.
                        </span>
                    </label>
                    <label class="flex items-start mt-2">
                        <input type="radio" name="report_mode" value="named" class="mt-1"
                               @checked(old('report_mode') === 'named')>
                        <span class="ms-2 text-sm text-gray-700">
                            <strong>Use my name</strong>: my name is attached to this report.
                        </span>
                    </label>
                    <x-input-error :messages="$errors->get('report_mode')" class="mt-2" />
                </div>

                {{-- Date, time and location --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div>
        <x-input-label for="incident_date" value="When did it happen?" />
        <x-text-input id="incident_date" type="date" name="incident_date" class="block mt-1 w-full"
                      :value="old('incident_date')" max="{{ now()->toDateString() }}" required />
        <x-input-error :messages="$errors->get('incident_date')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="incident_time" value="About what time? (optional)" />
        <x-text-input id="incident_time" type="time" name="incident_time" class="block mt-1 w-full"
                      :value="old('incident_time')" />
        <x-input-error :messages="$errors->get('incident_time')" class="mt-2" />
        <p class="text-xs text-gray-500 mt-1">Leave blank if you don't remember.</p>
    </div>

    <div>
        <x-input-label for="location_id" value="Where did it happen?" />
        <select id="location_id" name="location_id" required
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
            <option value="">Select a place</option>
            @foreach ($locations as $location)
                <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>
                    {{ $location->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
    </div>
</div>

                {{-- People involved --}}
                <div>
                    <p class="font-medium text-gray-800">Who was involved? <span class="text-sm text-gray-500">(optional)</span></p>
                    @for ($i = 0; $i < 3; $i++)
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mt-2">
                            <input type="text" name="parties[{{ $i }}][name]" placeholder="Name"
                                   value="{{ old("parties.$i.name") }}"
                                   class="sm:col-span-2 border-gray-300 rounded-md shadow-sm">
                            <select name="parties[{{ $i }}][role]" class="border-gray-300 rounded-md shadow-sm">
                                <option value="">Role</option>
                                <option value="victim" @selected(old("parties.$i.role") === 'victim')>Victim</option>
                                <option value="aggressor" @selected(old("parties.$i.role") === 'aggressor')>Aggressor</option>
                                <option value="witness" @selected(old("parties.$i.role") === 'witness')>Witness</option>
                            </select>
                        </div>
                    @endfor
                </div>

                {{-- Description --}}
                <div>
                    <x-input-label for="description" value="What happened?" />
                    <textarea id="description" name="description" rows="6" required
                              class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                              placeholder="Tell us in your own words. You may write in English, Filipino, or Taglish.">{{ old('description') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Details like time and place may hint at who you are.</p>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                {{-- Checkboxes --}}
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="repeated" value="1" class="rounded border-gray-300" @checked(old('repeated'))>
                        <span class="ms-2 text-sm text-gray-700">This has happened before.</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="someone_hurt" value="1" class="rounded border-gray-300" @checked(old('someone_hurt'))>
                        <span class="ms-2 text-sm text-gray-700">Someone was physically hurt.</span>
                    </label>
                </div>

                {{-- Evidence --}}
                <div>
                    <x-input-label for="evidence" value="Evidence (optional)" />
                    <input id="evidence" type="file" name="evidence[]" multiple accept=".jpg,.jpeg,.png,.pdf"
                           class="block mt-1 w-full text-sm">
                    <p class="text-xs text-gray-500 mt-1">Up to 3 files (JPG, PNG, PDF), 5 MB each.</p>
                    <x-input-error :messages="$errors->get('evidence')" class="mt-2" />
                    <x-input-error :messages="$errors->get('evidence.*')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>Submit Report</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>