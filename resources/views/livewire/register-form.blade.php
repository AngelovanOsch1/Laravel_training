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
                <x-form-select
                    id="gender"
                    name="form.gender"
                    model="form.gender"
                >
                    <option value="">Select your gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </x-form-select>
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
            <div class="mb-5">
                <x-form-label for="birthYear" text="Your date of birth" />
                <x-form-input
                    type="date"
                    id="birthYear"
                    name="form.birthYear"
                    model="form.birthYear"
                />
            </div>
        </div>        
    </div>
    <x-primary-button type='submit' text='Sign up' />    
</form>