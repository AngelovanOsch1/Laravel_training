<header class="bg-gray-900">
    <div class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div x-data="{ open: false }" class="relative">
                @auth
                    <button type="button" class="overflow-hidden rounded-full border border-gray-700 shadow-inner"
                        @click="open = !open">
                        <span class="sr-only">Open profile menu</span>
                        <img src="{{ asset('storage/' . $profilePhoto) }}" alt="Profile"
                            class="h-12 w-12 object-cover rounded-full" />
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white z-50" role="menu">
                        <x-nav-link href="{{ route('profile') }}" text="My Profile"
                            class="block rounded-lg px-4 py-2 text-sm" />

                        <x-nav-link href="{{ route('chat') }}" text="My chats" class="block rounded-lg px-4 py-2 text-sm" />
                    </div>
                @endauth

            </div>

            <div class="md:flex md:items-center md:gap-12">
                <div class="flex items-center gap-4">
                    <div class="sm:flex sm:gap-4">
                        @auth
                            <x-primary-button text="Logout" type="button" click="logout"
                                class="rounded-md bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700 cursor-pointer" />
                        @endauth
                        @guest
                            <x-nav-link href="{{ route('login') }}" text="Login" :active="Route::is('login')"
                                activeClass="bg-teal-600 text-white"
                                class="rounded-md bg-gray-800 px-5 py-2.5 text-sm font-medium text-white hover:text-white/75" />
                            <div class="hidden sm:flex">
                                <x-nav-link href="{{ route('register') }}" text="Register" :active="Route::is('register')"
                                    activeClass="bg-teal-600 text-white"
                                    class="rounded-md bg-gray-800 px-5 py-2.5 text-sm font-medium text-white hover:text-white/75" />
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
