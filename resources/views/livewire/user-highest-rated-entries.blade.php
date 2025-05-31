<div class="my-10 w-full rounded-xl bg-white px-6 py-6 shadow-lg shadow-[#e0e0e0]">
    <h3 class="text-xl font-bold mb-4">Top Rated Anime</h3>
    <div class="flex gap-5 justify-center items-center">
        @foreach ($topRatedSeries as $series)
            <div class="flex flex-col gap-2 transition-transform duration-200 hover:scale-105">
                <img src="{{ asset($series->cover_image) }}"
                    alt="{{ $series->title }}"class="h-30 w-auto mx-auto rounded-md shadow-sm" />
                <div class="flex gap-2 justify-center items-center">
                    <div class="font-bold">{{ $series->pivot->score }}</div>
                    <img src="{{ asset('storage/images/star.svg') }}" class="w-7 h-7" alt="Star Icon">
                </div>
            </div>
        @endforeach
    </div>
</div>
