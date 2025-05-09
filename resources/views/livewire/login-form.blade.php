<div class="max-w-md mx-auto p-6 rounded-xl bg-white shadow-lg shadow-[#e0e0e0]">
  <h2 class="text-xl font-bold text-left mb-4">Login</h2>
  <form wire:submit.prevent="submit">
    <div class="mb-5">
      <x-form-label 
        for="email" 
        text="Your email"
      />
      <x-form-input
        id="email" 
        name="form.email"
        placeholder="email..."
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
        model="form.password"
      />
    </div>
    <x-primary-button
      text='Login'
    />
  </form>
</div>