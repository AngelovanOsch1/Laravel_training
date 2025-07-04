<div class="max-w-md mx-auto p-6 rounded-xl bg-white shadow-lg shadow-[#e0e0e0]">
    <h2 class="text-xl font-bold text-left mb-4">Login</h2>
    <form wire:submit.prevent="submit">
        <div class="mb-5">
            <x-form-label for="email" text="Your email" />
            <x-form-input id="email" name="form.email" placeholder="Email..." model="form.email" />
        </div>
        <div class="mb-5">
            <x-form-label for="password" text="Your password" />
            <x-form-input type="password" id="password" name="form.password" placeholder="Password..."
                model="form.password" />
        </div>
        <div class="flex items-start mb-5">
            <div class="flex items-center h-5">
                <x-form-input type="checkbox" id="remember" name="form.rememberMe" model="form.rememberMe" class="accent-[#00897B] h-3 w-3 rounded"/>
            </div>
            <x-form-label for="remember" class="ms-2 text-sm font-medium text-gray-700" text="Remember me" />
        </div>

        <x-primary-button text="Login" />
    </form>
</div>
