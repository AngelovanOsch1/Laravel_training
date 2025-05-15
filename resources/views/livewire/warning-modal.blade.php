<div>
    @if($show)
        <div class="fixed inset-0 flex justify-center items-center z-50 bg-gray-800/25">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold">Warning</h2>
                <hr class="my-6 border-t border-gray-300" />
                @foreach($errors as $error)
                    <p class="text-sm text-red-600">{{ $error }}</p>
                @endforeach
                <div class="mt-4">
                    <x-primary-button 
                    type="button"
                    click="closeModal"
                    text="Close" />
                </div>
            </div>
        </div>
    @endif
</div>
