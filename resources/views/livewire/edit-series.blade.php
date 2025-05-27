<div>
    @if($show)
        <div class="fixed inset-0 flex justify-center items-center z-50 bg-gray-800/25">
            <div class="bg-white p-6 rounded-lg shadow-lg w-2xl">
                <form wire:submit.prevent="submit">
                    <h2 class="text-lg font-semibold">Edit Series</h2>
                    <p>Please fill in the form to update the series.</p>

                    <hr class="my-6 border-t border-gray-300" />
                                    <div class="flex flex-col gap-6">
                                        <div>
                                            <x-form-label for="series_status" text="Series status" />
                                            <x-form-select
                                                id="series_status"
                                                name="form.series_status"
                                                model="form.series_status"
                                            >
                                                <x-form-option text="Select a series status" />
                                                    @foreach($series_statuses as $series_status)
                                                    <x-form-option value="{{ $series_status->id }}" text="{{ $series_status->name }}" />
                                                    @endforeach
                                            </x-form-select>
                                        </div>
                                        <div class="flex flex-col md:flex-row gap-4">
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="episodes" text="Episodes" />
                                                <x-form-select
                                                    id="episodes"
                                                    name="form.episodes"
                                                    model="form.episodes"
                                                >
                                                    @foreach(range(0, $selectedSeries->series->episodes) as $episode)
                                                        <x-form-option value="{{ $episode }}" text="{{ $episode }}" />
                                                    @endforeach
                                                </x-form-select>
                                            </div>
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="score" text="Score" />
                                                <x-form-select
                                                    id="score"
                                                    name="form.score"
                                                    model="form.score"
                                                >
                                                    @foreach(range(0, 10) as $score)
                                                        <x-form-option value="{{ $score }}" text="{{ $score }}" />
                                                    @endforeach
                                                </x-form-select>
                                            </div>
                                        </div>
                                        <div class="flex flex-col md:flex-row gap-4">
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="start_date" text="Start date" />
                                                <x-form-input
                                                    id="start_date"
                                                    type="date"
                                                    name="form.start_date"
                                                    model="form.start_date"
                                                />
                                            </div>
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="end_date" text="End date" />
                                                <x-form-input
                                                    id="end_date"
                                                    type="date"
                                                    name="form.end_date"                                             
                                                    model="form.end_date"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                      <div class="flex justify-between mt-10">
                        <x-primary-button
                            type="button"
                            text="Cancel"
                            class="text-gray-700 bg-gray-200 hover:bg-gray-300
                                   font-medium rounded-lg text-sm
                                   px-5 py-2.5 w-full sm:w-auto text-center
                                   dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600
                                   shadow-sm transition-colors duration-150 cursor-pointer"
                            click="closeModal"
                        />
                        <x-primary-button text="Save" />
                    </div>
                                </form>
            </div>
        </div>
    @endif
</div>