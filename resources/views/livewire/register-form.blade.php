<form class="max-w-4xl mx-auto" wire:submit.prevent="submit">
    <div class="flex gap-8">
        <div class="w-full md:w-1/2 flex flex-col">
            <div class="mb-5">
                <x-form-label for="email" text="Your email" />
                <x-form-input
                    id="email" 
                    name="form.email"
                    placeholder="email..."
                    model="form.email"
                />
            </div>
            <div class="mb-5">
                <x-form-label for="password" text="Your password" />
                <x-form-input
                    type="password" 
                    id="password" 
                    name="form.password"
                    placeholder="password..."
                    model="form.password"
                />
            </div>
            <div class="mb-5">
                <x-form-label for="password_confirmation" text="Confirm password" />
                <x-form-input
                    type="password" 
                    id="password_confirmation" 
                    name="form.password"
                    placeholder="confirm password..."
                    model="form.password_confirmation"
                />
            </div>
            <div class="mb-5">
                <x-form-label for="gender" text="Your gender" />
                <div class="flex items-center space-x-6 mt-5">
                        <x-form-input
                            type="radio"
                            id="genderMale"
                            value="Male"
                            model="form.gender"
                            class="w-5 h-5 accent-gray-700 rounded-full border border-gray-400 transition-all duration-200"
                        />
                        <span>Male</span>
                        <x-form-input
                            type="radio"
                            id="genderFemale"
                            value="Female"
                            model="form.gender"
                            class="w-5 h-5 accent-gray-700 rounded-full border border-gray-400 transition-all duration-200"
                        />
                        <span>Female</span>
                    </label>
                        <x-form-input
                            type="radio"
                            id="genderOther"
                            value="Other"
                            model="form.gender"
                            class="w-5 h-5 accent-gray-700 rounded-full border border-gray-400 transition-all duration-200"
                        />
                        <span>Other</span>
                    </label>
                </div>
                @error('form.gender')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>                       
        </div>
        <div class="w-full md:w-1/2">
            <div class="mb-5">
                <x-form-label for="firstName" text="Your first name" />
                <x-form-input
                    id="firstName" 
                    name="form.firstName"
                    placeholder="first name..."
                    model="form.firstName"
                />
            </div>
            <div class="mb-5">
                <x-form-label for="lastName" text="Your last name" />
                <x-form-input
                    id="lastName" 
                    name="form.lastName"
                    placeholder="last name..."
                    model="form.lastName"
                />
            </div>
            <div class="mb-5">
                <x-form-label for="country" text="Your country" />
                <x-form-input
                    id="country" 
                    name="form.country"
                    placeholder="country..."
                    model="form.country"
                />
            </div>
            <x-form-label for="birthYear" text="Your birth year" />
            <div class="mb-5">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <x-form-input
                        :datepicker="true"
                        id="birthYear" 
                        name="form.birthYear"
                        placeholder="Select date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        model="form.birthYear"
                    />
                </div>
            </div>
        </div>        
    </div>
    <x-primary-button type='submit' text='Sign up' />    
</form>