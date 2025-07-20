<div class="mt-5">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg shadow-[#c0c0c0]">
        <form class="p-10 flex flex-col gap-5" wire:submit.prevent="submit">
            <h3 class="text-xl font-bold mb-3 text-left">Contact us</h3>

            <div class="flex flex-col md:flex-row gap-5">
                <div class="w-full">
                    <x-form-label for="name" text="Your name" />
                    <x-form-input id="name" name="form.name" placeholder="Name..." model="form.name" />
                </div>
                <div class="w-full">
                    <x-form-label for="email" text="Your email" />
                    <x-form-input id="email" name="form.email" placeholder="Email..." model="form.email" />
                </div>
            </div>

            <div>
                <x-form-label for="message" text="Your message" />
                <x-form-textarea id="message" name="form.message" placeholder="Enter up to 500 characters..."
                    rows="5" liveModel="form.message" maxCharacters="500" />
            </div>
            <x-primary-button text="Send" click="submit" icon="send"
                class="text-white font-medium rounded-lg text-sm px-4 py-2 text-center bg-teal-600 hover:bg-teal-500 inline-flex items-center gap-2 w-fit" />
        </form>
    </div>
</div>
