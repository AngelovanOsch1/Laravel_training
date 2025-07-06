<div x-data x-init="$watch('$wire.show', value => window.toggleBodyScroll(value))">
    @if ($show)
        <div class="fixed inset-0 flex justify-center items-center z-50 bg-gray-800/25" @click="$wire.closeModal()">
            <div class="bg-gray-100 p-6 rounded-lg shadow-lg w-full max-w-[915px] min-h-[610px] flex flex-col" @click.stop>
                <div class="flex-1 flex flex-col">
                    @if ($stepCount === 0)
                        <div>
                            <div class="relative w-full">
                                <x-form-input type="search" placeholder="Search series..."
                                    class="border border-gray-300 bg-white text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                    liveModel="query" icon="search" />
                            </div>
                            @if ($results->isEmpty())
                                @if (strlen($query) >= 2)
                                    <p class="mt-2 pl-2 text-gray-500">No series found matching
                                        "<strong>{{ $query }}</strong>"</p>
                                @else
                                    <p class="mt-2 pl-2 text-gray-500">you've already added all available ones.</p>
                                @endif
                            @else
                                <div class="max-h-[400px] overflow-y-auto mt-12 scrollbar-hidden">
                                    <ul class="grid grid-cols-[repeat(auto-fit,160px)] gap-4">
                                        @foreach ($results as $series)
                                            <li wire:click="setSelectedIndex({{ $series->id }})"
                                                class="animate-fade-in rounded-lg bg-white p-3 shadow-lg hover:shadow-md transition cursor-pointer border-2"
                                                style="{{ isset($selectedSeries['id']) && $series->id === $selectedSeries['id'] ? 'border-color: #00897B;' : 'border-color: transparent;' }}">
                                                <div class="h-48 mb-2 rounded-md overflow-hidden flex shadow-lg">
                                                    <img src="{{ asset($series->cover_image) }}"
                                                        alt="{{ $series->title }}" class="min-w-[150px] object-cover" />
                                                </div>
                                                <h3 class="text-md font-semibold truncate">{{ $series->title }}</h3>
                                                <p class="text-sm text-gray-600">{{ $series->type }}</p>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    <img src="{{ asset('storage/images/star.svg') }}"
                                                        class="w-5 h-5 inline-block" alt="Star Icon">
                                                    {{ number_format($series->score, 1) }}
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div x-intersect.full="$wire.loadMore()" class="mt-10 flex justify-center">
                                        <div wire:loading wire:target="loadMore"
                                            class="flex justify-center items-center">
                                            <img src="{{ asset('storage/images/spinner.svg') }}" class="h-10 w-10" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="flex gap-8 flex-col md:flex-row">
                            <div class="w-full md:w-2/3 bg-white p-6 shadow-lg rounded-xl">
                                <form wire:submit.prevent="submit">
                                    <div class="flex flex-col gap-6">
                                        <div>
                                            <x-form-label for="title" text="Series Title" />
                                            <x-form-input id="title" name="selectedSeries.title" :readOnly="true"
                                                model="selectedSeries.title" />
                                        </div>
                                        <div>
                                            <x-form-label for="type" text="Series Type" />
                                            <x-form-input id="type" name="selectedSeries.type" :readOnly="true"
                                                model="selectedSeries.type" />
                                        </div>
                                        <div>
                                            <x-form-label for="series_status" text="Series status" />
                                            <x-form-select id="series_status" name="form.series_status"
                                                model="form.series_status">
                                                <x-form-option text="Select a series status" />
                                                @foreach ($series_statuses as $series_status)
                                                    <x-form-option value="{{ $series_status->id }}"
                                                        text="{{ $series_status->name }}" />
                                                @endforeach
                                            </x-form-select>
                                        </div>
                                        <div class="flex flex-col md:flex-row gap-4">
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="episode_count" text="Episodes" />
                                                <x-form-select id="episode_count" name="form.episode_count"
                                                    :disabled="$selectedSeries['aired_start_date'] > now()" model="form.episode_count">
                                                    <x-form-option text="Select episodes" />
                                                    @foreach (range(0, $selectedSeries['episode_count']) as $episode)
                                                        <x-form-option value="{{ $episode }}"
                                                            text="{{ $episode }}" />
                                                    @endforeach
                                                </x-form-select>
                                            </div>
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="score" text="Score" />
                                                <x-form-select id="score" name="form.score" :disabled="$selectedSeries['aired_start_date'] > now()"
                                                    model="form.score">
                                                    <x-form-option text="Select your score" />
                                                    @foreach (range(1, 10) as $score)
                                                        <x-form-option value="{{ $score }}"
                                                            text="{{ $score }}" />
                                                    @endforeach
                                                </x-form-select>
                                            </div>
                                        </div>
                                        <div class="flex flex-col md:flex-row gap-4">
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="start_date" text="Start date" />
                                                <x-form-input id="start_date" type="date" name="form.start_date"
                                                    :readOnly="$selectedSeries['aired_start_date'] > now()" model="form.start_date" />
                                            </div>
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="end_date" text="End date" />
                                                <x-form-input id="end_date" type="date" name="form.end_date"
                                                    :readOnly="$selectedSeries['aired_start_date'] > now()" model="form.end_date" />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="w-full md:w-1/3 rounded-md overflow-hidden flex items-center justify-center">
                                <img src="{{ asset($selectedSeries['cover_image']) }}"
                                    alt="{{ $selectedSeries['title'] }}"
                                    class="max-h-full max-w-full object-contain" />
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-4 flex items-center justify-between pt-4 space-x-4">
                    <x-primary-button type="button" :text="$stepCount === 0 ? 'Cancel' : 'Back'"
                        class="min-w-[100px] text-gray-200 bg-gray-700 hover:bg-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto text-center shadow-sm transition-colors duration-150 cursor-pointer"
                        click="previousStep" />
                    <div class="flex space-x-2">
                        <div
                            class="w-2 h-2 rounded-full transition-all duration-300 {{ $stepCount === 0 ? 'bg-teal-600' : 'bg-gray-600' }}">
                        </div>
                        <div
                            class="w-2 h-2 rounded-full transition-all duration-300 {{ $stepCount === 1 ? 'bg-teal-600' : 'bg-gray-600' }}">
                        </div>
                    </div>
                    <x-primary-button :type="$stepCount === 0 ? 'button' : 'submit'" :text="$stepCount === 0 ? 'Next' : 'Submit'" :disabled="is_null($selectedSeries)"
                        class="min-w-[100px] px-5 py-2.5 text-white bg-teal-600 hover:bg-teal-500
                               font-medium rounded-lg text-sm text-center
                               inline-flex items-center gap-3 justify-center cursor-pointer"
                        click="nextStep" />
                </div>
            </div>
        </div>
    @endif
</div>
