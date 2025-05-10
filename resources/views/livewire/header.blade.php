<!-- Header Section -->
<header class="bg-white dark:bg-gray-900">
    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="relative">
                @auth
                    <button type="button" class="overflow-hidden rounded-full border border-gray-300 shadow-inner"
                        onclick="document.getElementById('profileDropdown').classList.toggle('hidden')">
                @endauth
                <a href="{{ route('dashboard') }}">
                    <span class="sr-only">Go to homepage</span>
                    <img
                        src="https://static-00.iconduck.com/assets.00/profile-user-icon-512x512-nm62qfu0.png" 
                        alt="Profile"
                        class="h-12 w-12 object-cover rounded-full" 
                    />
                </a>
                </button>

                <div id="profileDropdown"
                    class="absolute right-0 mt-2 w-56 rounded-md border border-gray-100 bg-white shadow-lg hidden"
                    role="menu">
                    <x-nav-link href="{{ route('profile') }}" text="My Profile"
                        class="block rounded-lg px-4 py-2 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700" />
                </div>
            </div>

            <div class="md:flex md:items-center md:gap-12">
                <div class="flex items-center gap-4">
                    <div class="sm:flex sm:gap-4">
                        @auth
                            <x-primary-button text="Logout" type="button" click="logout"
                                class="rounded-md bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700 dark:bg-red-500 dark:text-white dark:hover:bg-red-600" />
                        @endauth
                        @guest
                            <x-nav-link 
                                href="{{ route('login') }}" 
                                text="Login" 
                                :active="Route::is('login')"
                                class="rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600 dark:bg-gray-800 dark:text-white dark:hover:text-white/75" 
                            />
                            <div class="hidden sm:flex">
                                <x-nav-link href="{{ route('register') }}" text="Register" :active="Route::is('register')"
                                    class="rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600 dark:bg-gray-800 dark:text-white dark:hover:text-white/75" />
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
