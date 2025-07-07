<div class="bg-white h-full overflow-y-auto p-4 space-y-4">
    @forelse($messages ?? [] as $message)
        <div class="flex flex-col">
            <span class="text-sm text-gray-500 font-medium">
                {{ $message->sender->name ?? 'Unknown' }}
            </span>
            <span class="text-xs text-gray-400">
                {{ $message->created_at->diffForHumans() }}
            </span>
            <div class="bg-gray-100 p-3 rounded-xl text-sm text-gray-800 max-w-md mt-1">
                {{ $message->body }}
            </div>
        </div>
    @empty
        <div class="flex flex-col justify-center items-center h-full text-gray-400">
            <img src="{{ asset('storage/images/chat.png') }}" class="h-32 w-32 mb-4" />
            <span>Start the conversation!</span>
        </div>
    @endforelse
</div>
