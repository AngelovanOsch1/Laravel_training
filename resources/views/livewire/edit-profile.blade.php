<div>
    @if ($show)
        <div class="fixed inset-0 flex justify-center items-center z-50 bg-gray-800/25">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <form class="flex flex-col" wire:submit.prevent="submit">
                    <h2 class="text-lg font-semibold">Edit Profile</h2>
                    <p>Please fill in the form to update your profile details.</p>

                    <hr class="my-6 border-t border-gray-300" />

                    <div class="mb-5">
                        <x-form-label for="firstName" text="Your first name" />
                        <x-form-input id="firstName" name="form.firstName" placeholder="First name..."
                            model="form.firstName" />
                    </div>
                    <div class="mb-5">
                        <x-form-label for="lastName" text="Your last name" />
                        <x-form-input id="lastName" name="form.lastName" placeholder="Last name..."
                            model="form.lastName" />
                    </div>
                    <div class="mb-5">
                        <x-form-label for="country" text="Your country" />
                        <x-form-select id="country" name="form.country" model="form.country">
                            @foreach ($countries as $country)
                                <x-form-option value="{{ $country->id }}" text="{{ $country->name }}" />
                            @endforeach
                        </x-form-select>
                    </div>

                    <div class="mb-5">
                        <x-form-label for="gender" text="Your gender" />
                        <x-form-select id="gender" name="form.gender" model="form.gender">
                            @foreach ($genders as $gender)
                                <x-form-option value="{{ $gender->id }}" text="{{ $gender->name }}" />
                            @endforeach
                        </x-form-select>
                    </div>

                    <div class="mb-5">
                        <x-form-label for="date_of_birth" text="Your date of birth" />
                        <x-form-input type="date" id="date_of_birth" name="form.date_of_birth"
                            model="form.date_of_birth" />
                    </div>

                    <div class="mb-5">
                        <x-form-label for="description" text="Your description" />
                        <x-form-textarea id="description" name="form.description"
                            placeholder="Enter up to 100 characters..." rows="4" model='form.description'
                            maxCharacters="100" />
                    </div>
                    <div class="flex justify-between mt-4">
                        <x-primary-button type="button" text="Cancel"
                            class="font-medium rounded-lg text-sm
                                   px-5 py-2.5 w-full sm:w-auto text-center
                                   bg-gray-700 text-gray-200 hover:bg-gray-600
                                   shadow-sm transition-colors duration-150 cursor-pointer"
                            click="closeModal" />
                        <x-primary-button text="Save" />
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
