<div>
    <div class="mt-5 flex justify-between w-full gap-x-25">
        <div
            class="my-10 flex flex-col max-h-[850px] min-w-[300px] items-center rounded-xl bg-white px-6 py-6 text-center md:max-w-md shadow-lg shadow-[#c0c0c0]">
            <div class="mb-4">
                <label class="relative block w-56 group">
                    <img src="{{ asset($series->cover_image) }}"
                        class="w-full h-auto object-contain rounded-xl pointer-events-none" alt="default-profile-photo" />
                </label>
            </div>
            <h2 class="text-xl font-bold text-gray-800">{{ $series->title }}</h2>
            <hr class="my-6 w-full border-t border-gray-300" />
            <div class="w-full space-y-4 mt-4">
                <div class="flex justify-between text-sm text-gray-700">
                    <span>Type</span>
                    <span>{{ $series->type }} </span>
                </div>
                <div class="flex justify-between text-sm text-gray-700">
                    <span>Episodes</span>
                    <span>{{ $series->episode_count }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-700">
                    <span>Status</span>
                    <span>{{ $airingStatus }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-700">
                    <span>Aired</span>
                    <span> {{ \Carbon\Carbon::parse($series->aired_start_dat)->format('M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($series->aired_end_date)->format('M Y') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-700">
                    <span>Premiered</span>
                    <span>{{ $premiered }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-700">
                    <span>Studios</span>
                    <span>{{ $series->studios->pluck('name')->implode(', ') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-700">
                    <span>Genres</span>
                    <span>{{ $series->genres->pluck('name')->implode(', ') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-700">
                    <span>Duration per episode</span>
                    <span>{{ $series->minutes_per_episode }}</span>
                </div>
            </div>
            <hr class="my-6 w-full border-t border-gray-300" />
            <div class="flex gap-4">
                <x-primary-button type="button" text="Likes {{ $reactionsObject->likeCount }}" :icon="$series->authUserReactedWith('like') ? 'thumbs-up' : 'thumbs-o-up'"
                    iconPosition="right" click="toggleReactionSeries('like')"
                    class="px-4 py-2 bg-white text-green-600 font-medium rounded border border-green-600 shadow hover:bg-green-50 flex items-center gap-2 text-sm w-full justify-center whitespace-nowrap transition-colors duration-200" />
                <x-primary-button type="button" text="Dislikes {{ $reactionsObject->dislikeCount }}" :icon="$series->authUserReactedWith('dislike') ? 'thumbs-down' : 'thumbs-o-down'"
                    i iconPosition="right" click="toggleReactionSeries('dislike')"
                    class="px-4 py-2 bg-white text-rose-600 font-medium rounded border border-rose-600 shadow hover:bg-rose-50 flex items-center gap-2 text-sm w-full justify-center whitespace-nowrap transition-colors duration-200" />

            </div>
        </div>
        <div class="flex-grow">
            <div
                class="my-10 flex flex-col w-full rounded-xl bg-white px-6 py-6 text-center shadow-lg shadow-[#c0c0c0]">
                <div class="flex justify-between items-center w-full gap-6">
                    <div
                        class="flex flex-col items-center rounded-lg px-5 py-4 w-28 bg-white shadow-lg shadow-[#c0c0c0]">
                        <span
                            class="text-sm font-semibold bg-teal-600 text-white rounded px-6 uppercase py-1">Score</span>
                        <span class="text-3xl font-extrabold mt-3 text-gray-900">{{ $series->score }}</span>
                        <span class="text-xs mt-1 text-gray-600">users ({{ $amountOfVotes }})</span>
                        <span
                            class="mt-3 inline-block bg-teal-600 text-white rounded-full px-3 py-1 text-xs font-semibold">Rank
                            #{{ $seriesRank }}</span>
                    </div>

                    <iframe width="320" height="180" src="https://www.youtube.com/embed/{{ $series->video }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen class="rounded-lg shadow-lg">
                    </iframe>

                </div>

                <hr class="my-6 w-full border-t border-gray-300" />
                <h5 class="text-l font-bold mb-8 text-left">Synopsis</h5>
                <p class="text-left text-sm text-gray-700">
                    {{ $series->synopsis }}
                </p>
            </div>
            <div
                class="my-10 flex flex-col w-full rounded-xl bg-white px-6 py-6 text-center shadow-lg shadow-[#c0c0c0]">
                <h3 class="text-xl font-bold mb-8 text-left">Characters & Voice Actors</h3>
                <div class="flex flex-col gap-3">
                    <div class="flex flex-wrap justify-between gap-6">
                        <div
                            class="flex items-center justify-between bg-white rounded-xl p-4 w-full md:w-[48%] shadow-lg shadow-[#c0c0c0]">
                            <div class="flex gap-4">
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                                <p class="text-gray-800 font-semibold">Frieren</p>
                            </div>
                            <div class="flex gap-4">
                                <p class="text-gray-800 font-semibold">Frieren</p>
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between bg-white rounded-xl p-4 w-full md:w-[48%] shadow-lg shadow-[#c0c0c0]">
                            <div class="flex gap-4">
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                                <p class="text-gray-800 font-semibold">Frieren</p>
                            </div>
                            <div class="flex gap-4">
                                <p class="text-gray-800 font-semibold">Frieren</p>
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-between gap-6">
                        <div
                            class="flex items-center justify-between bg-white rounded-xl p-4 w-full md:w-[48%] shadow-lg shadow-[#c0c0c0]">
                            <div class="flex gap-4">
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                                <p class="text-gray-800 font-semibold">Frieren</p>
                            </div>
                            <div class="flex gap-4">
                                <p class="text-gray-800 font-semibold">Frieren</p>
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between bg-white rounded-xl p-4 w-full md:w-[48%] shadow-lg shadow-[#c0c0c0]">
                            <div class="flex gap-4">
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                                <p class="text-gray-800 font-semibold">Frieren</p>
                            </div>
                            <div class="flex gap-4">
                                <p class="text-gray-800 font-semibold">Frieren</p>
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-between gap-6">
                        <div
                            class="flex items-center justify-between bg-white rounded-xl p-4 w-full md:w-[48%] shadow-lg shadow-[#c0c0c0]">
                            <div class="flex gap-4">
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                                <p class="text-gray-800 font-semibold">Frieren</p>
                            </div>
                            <div class="flex gap-4">
                                <p class="text-gray-800 font-semibold">Frieren</p>
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between bg-white rounded-xl p-4 w-full md:w-[48%] shadow-lg shadow-[#c0c0c0]">
                            <div class="flex gap-4">
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                                <p class="text-gray-800 font-semibold">Frieren</p>
                            </div>
                            <div class="flex gap-4">
                                <p class="text-gray-800 font-semibold">Frieren</p>
                                <img src="{{ asset($series->cover_image) }}" alt="Cover"
                                    class="w-20 h-28 object-cover rounded-md shadow" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<div
    class="my-10 flex flex-col w-full rounded-xl bg-white px-6 py-6 text-center shadow-lg shadow-[#c0c0c0]">
    <h3 class="text-xl font-bold mb-8 text-left">Songs</h3>
    <div class="flex justify-between gap-10">
        <div class="flex flex-col text-sm text-gray-800 flex-1">
            <h5 class="text-base font-bold mb-1 text-left">Opening Theme</h5>
            <hr class="mb-4 w-full border-t border-gray-300" />
            <ul class="space-y-2 pl-2">
                @foreach ($openingThemes as $theme)
                    <li class="flex items-center justify-between gap-3">
                        <div
                            class="flex items-start gap-3 cursor-pointer play-btn"
                            data-audio-id="audio-opening-{{ $theme->id }}">
                            <div
                                class="w-6 h-6 flex items-center justify-center bg-teal-600 text-white rounded-full text-[0.6rem] play-icon">
                                <i class="fa fa-play fa-sm"></i>
                            </div>
                            <p>
                                "{{ $theme->title }}" by {{ $theme->artist }}
                            </p>
                        </div>
                        <audio id="audio-opening-{{ $theme->id }}" preload="none" style="display:none;">
                            <source src="{{ asset($theme->audio_url) }}" type="audio/mpeg">
                        </audio>
                        <div class="bg-teal-600 text-white text-[0.65rem] px-2 py-0.5 rounded-full font-semibold">MV</div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="flex flex-col text-sm text-gray-800 flex-1">
            <h5 class="text-base font-bold mb-1 text-left">Ending Theme</h5>
            <hr class="mb-4 w-full border-t border-gray-300" />
            <ul class="space-y-2 pl-2">
                @foreach ($endingThemes as $theme)
                    <li class="flex items-center justify-between gap-3">
                        <div
                            class="flex items-start gap-3 cursor-pointer play-btn"
                            data-audio-id="audio-ending-{{ $theme->id }}">
                            <div
                                class="w-6 h-6 flex items-center justify-center bg-teal-600 text-white rounded-full text-[0.6rem] play-icon">
                                <i class="fa fa-play fa-sm"></i>
                            </div>
                            <p>
                                "{{ $theme->title }}" by {{ $theme->artist }}
                            </p>
                        </div>
                        <audio id="audio-ending-{{ $theme->id }}" preload="none" style="display:none;">
                            <source src="{{ asset($theme->audio_url) }}" type="audio/mpeg">
                        </audio>
                        <div class="bg-teal-600 text-white text-[0.65rem] px-2 py-0.5 rounded-full font-semibold">MV</div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
        </div>
    </div>
    <livewire:comments :id="$series->id" commentType="App\Models\Series" />
</div>
