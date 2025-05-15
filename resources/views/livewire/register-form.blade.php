<div class="max-w-4xl mx-auto p-6 rounded-xl bg-white shadow-lg shadow-[#e0e0e0]">
    <h2 class="text-xl font-bold text-left mb-6">Sign Up</h2>
    
    <form wire:submit.prevent="submit">
      <div class="flex gap-8 flex-col md:flex-row">
        <div class="w-full md:w-1/2 flex flex-col">
          <div class="mb-5">
            <x-form-label for="email" text="Your email" />
            <x-form-input
              type="email"
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
              <x-form-option value="" text="Select your gender" />
              <x-form-option value="Male" text="Male" />
              <x-form-option value="Female" text="Female" />
              <x-form-option value="Other" text="Other" />
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
      <x-primary-button 
        text='Sign up'  
      />
    </form>
  </div>