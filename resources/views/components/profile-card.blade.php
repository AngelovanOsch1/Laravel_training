@props([
    'user' => null,
])

<div class="my-10 flex flex-col items-center rounded-xl bg-white px-6 py-6 text-center md:max-w-md shadow-lg shadow-[#e0e0e0]">
  <div class="mb-4">
    <livewire:profile-photo :profilePhoto="$user->profile_photo" />
  </div>
  <div>
    <h2 class="text-xl font-bold text-gray-800">{{ $user->first_name . ' ' . $user->last_name }}</h2>
    <span class="inline-block mt-1 rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-700">User</span>
    <p class="mt-2 text-gray-600 w-[200px] mx-auto text-center break-words">{{ $user->description }}</p>
    <hr class="my-6 border-t border-gray-300" />
        <div class="w-full space-y-4 mt-4">
      <div class="flex justify-between text-sm text-gray-700">
        <span>Date of Birth</span>
        <span>{{ $user->date_of_birth->format('F j, Y') }}</span>
      </div>
      <div class="flex justify-between text-sm text-gray-700">
        <span>Gender</span>
        <span>{{ $user->gender }}</span>
      </div>
      <div class="flex justify-between text-sm text-gray-700">
        <span>Country</span>
        <span>{{ $user->country }}</span>
      </div>
      <div class="flex justify-between text-sm text-gray-700">
        <span>Joined</span>
        <span>{{ $user->created_at->format('F j, Y') }}</span>
      </div>
    </div>
    <hr class="my-6 border-t border-gray-300" />
    <div class="flex space-x-4 mt-6 w-full">
      <x-primary-button
        type="button"
        text='Like'
        icon='heart'
        iconPosition='right'
        class="flex-1 px-6 py-2 bg-pink-300 text-white font-semibold rounded-md shadow-md shadow-[#e0e0e0] hover:shadow-[#c0c0c0] hover:bg-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50 inline-flex items-center gap-3"
      />
      <x-primary-button
        type="button"
        text='Chat'
        icon='comments'
        iconPosition='right'
        class="flex-1 px-6 py-2 bg-green-300 text-white font-semibold rounded-md shadow-md shadow-[#e0e0e0] hover:shadow-[#c0c0c0] hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 inline-flex items-center gap-3"
      />
    </div>
  </div>
</div>