<form class="max-w-sm mx-auto" wire:submit.prevent="submit">
  <div class="mb-5">
      <x-form-label 
          for="email" 
          text="Your email" 
      />
      <x-form-input
          id="email" 
          name="email"
          placeholder="email..."
          :required="true"
          model="email"
      />
  </div>

  <div class="mb-5">
      <x-form-label 
          for="password" 
          text="Your password" 
      />
      <x-form-input
          type="password" 
          id="password" 
          name="password"
          placeholder="password..."
          :required="true"
          model="password"
      />
  </div>

  <div class="mb-5">
      <x-form-label 
          for="passwordConfirm"
          text="Confirm password" 
      />
      <x-form-input
          type="password" 
          id="passwordConfirm" 
          name="passwordConfirm"
          placeholder="confirm password..."
          :required="true"
          model="passwordConfirm"
      />
  </div>

  <x-primary-button
      type='submit'
      text='Sign up'
  />
</form>