<form class="max-w-sm mx-auto" wire:submit.prevent="submit">
    <div class="mb-5">
      <x-form-label 
        for="email" 
        text="Your email"
      />
      <x-form-input
        id="email" 
        name="form.email"
        placeholder="email..."
        :required="true"
        model="form.email"
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
        name="form.password"
        placeholder="password..."
        :required="true"
        model="form.password"
      />
    </div>
    <x-primary-button
      type='submit'
      text='Login'
    />
  </form>