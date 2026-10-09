<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- LRN -->
        <div>
            <x-input-label for="lrn" value="LRN (12 digits)" />
            <x-text-input id="lrn" class="block mt-1 w-full" type="text" name="lrn"
                :value="old('lrn')" required autofocus maxlength="12"
                inputmode="numeric" pattern="[0-9]{12}" />
            <x-input-error :messages="$errors->get('lrn')" class="mt-2" />
        </div>

        <!-- First Name -->
        <div class="mt-4">
            <x-input-label for="first_name" value="First Name" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                :value="old('first_name')" required />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" value="Last Name" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                :value="old('last_name')" required />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Grade Level -->
        <div class="mt-4">
            <x-input-label for="grade_level" value="Grade Level" />
            <select id="grade_level" name="grade_level" required
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Select grade</option>
                @foreach ([7, 8, 9, 10, 11, 12] as $grade)
                    <option value="{{ $grade }}" @selected(old('grade_level') == $grade)>Grade {{ $grade }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('grade_level')" class="mt-2" />
        </div>

        <!-- Section -->
        <div class="mt-4">
            <x-input-label for="section" value="Section" />
            <x-text-input id="section" class="block mt-1 w-full" type="text" name="section"
                :value="old('section')" required />
            <x-input-error :messages="$errors->get('section')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Privacy Notice (RA 10173) -->
        <div class="mt-4">
            <label class="inline-flex items-start">
                <input type="checkbox" name="privacy_consent" value="1" class="mt-1 rounded border-gray-300" required>
                <span class="ms-2 text-sm text-gray-600">
                    I agree that SafeSpace may collect my LRN, name, grade, and section, and the reports I submit,
                    for handling bullying incidents. Only the guidance counselor can see my information,
                    in accordance with the Data Privacy Act (RA 10173).
                </span>
            </label>
            <x-input-error :messages="$errors->get('privacy_consent')" class="mt-2" />
            <a href="{{ route('privacy') }}" target="_blank" class="underline text-xs text-gray-600">Read the full privacy notice</a>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                Already registered?
            </a>

            <x-primary-button class="ms-4">
                Register
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>