<x-modal 
    buttonText="Edit Profile"
    title="Edit Profile"
    description="Please fill in the form to update your profile details."
    closeButtonText="Cancel"
    saveButtonText="Save"
    submitForm="submit"
>
<hr class="my-6 border-t border-gray-300" />
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
    <div class="mb-5">
        <x-form-label for="birthYear" text="Your date of birth" />
        <x-form-input
          type="date"
          id="birthYear"
          name="form.birthYear"
          model="form.birthYear"
        />
    </div>
</x-modal>
