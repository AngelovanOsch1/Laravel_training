<div>
    @if($show)
        <div class="fixed inset-0 flex justify-center items-center z-50 bg-gray-800/25">
            <div class="bg-gray-100 p-6 rounded-lg shadow-lg w-full max-w-[910px] min-h-[600px] flex flex-col">    
                <div class="flex-1 flex flex-col">
                    @if($stepCount === 0)
                        <div>
                            <div class="relative w-full">
                                <x-form-input
                                    type="search"
                                    placeholder="Search series..."
                                    class="border border-gray-300 bg-white text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                    liveModel="query"
                                />
                            </div>
                            @if(strlen($query) <= 2)
                                <div class="flex flex-col items-center justify-center h-64 text-gray-400 mt-20 select-none">
                                    <svg 
                                        xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256"
                                        style="fill:#737373;">
                                            <g fill="#737373" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(4,4)"><path d="M32,6.96289c-0.505,0 -0.91211,0.40811 -0.91211,0.91211v1.82617c-0.001,0.504 0.40711,0.91406 0.91211,0.91406c0.505,0 0.91211,-0.41006 0.91211,-0.91406v-1.82617c0,-0.504 -0.40711,-0.91211 -0.91211,-0.91211zM26.91992,7.63086c-0.078,0 -0.15928,0.00925 -0.23828,0.03125c-0.487,0.131 -0.77648,0.63114 -0.64648,1.11914l0.47461,1.76367c0.131,0.488 0.63114,0.77653 1.11914,0.64453c0.487,-0.13 0.77453,-0.63019 0.64453,-1.11719l-0.47266,-1.76563c-0.109,-0.408 -0.47686,-0.67578 -0.88086,-0.67578zM37.08008,7.63086c-0.403,0 -0.77186,0.26778 -0.88086,0.67578l-0.47266,1.76367c-0.131,0.488 0.15853,0.98914 0.64453,1.11914c0.487,0.132 0.98814,-0.15653 1.11914,-0.64453l0.47266,-1.76563c0.131,-0.488 -0.15948,-0.98814 -0.64648,-1.11914c-0.079,-0.02 -0.15833,-0.0293 -0.23633,-0.0293zM22.18164,9.5918c-0.155,0 -0.31108,0.04005 -0.45508,0.12305c-0.437,0.252 -0.58698,0.81009 -0.33398,1.24609l0.91406,1.58203c0.253,0.437 0.81209,0.58598 1.24609,0.33398c0.437,-0.252 0.58698,-0.81009 0.33398,-1.24609l-0.91211,-1.58203c-0.17,-0.293 -0.47697,-0.45703 -0.79297,-0.45703zM41.81445,9.59375c-0.316,0 -0.62201,0.16303 -0.79102,0.45703l-0.91406,1.58203c-0.252,0.433 -0.10106,0.99309 0.33594,1.24609c0.436,0.251 0.99409,0.10202 1.24609,-0.33398l0.91406,-1.58203c0.252,-0.437 0.10202,-0.99409 -0.33398,-1.24609c-0.143,-0.083 -0.30103,-0.12305 -0.45703,-0.12305zM32,13.80664c-4.602,0 -9.26825,1.52191 -13.28125,4.25391c-0.932,-0.679 -2.04275,-1.06055 -3.21875,-1.06055c-1.432,0 -4.50002,-0.00034 -7.66602,7.72266c-1.256,3.063 -6.56686,11.67139 -6.63086,11.77539c-0.787,1.363 -1.20312,2.91995 -1.20312,4.50195c0,4.963 4.038,9 9,9c3.758,0 7.07058,-2.32472 8.39258,-5.76172c3.443,1.205 8.16742,1.95508 14.60742,1.95508c6.441,0 11.16638,-0.75008 14.60938,-1.95508c1.323,3.404 4.65962,5.76172 8.39063,5.76172c4.962,0 9,-4.037 9,-9c0,-1.325 -0.28189,-2.60287 -0.83789,-3.79687l-0.0625,-0.11328c-0.059,-0.093 -5.92495,-9.34519 -7.25195,-12.36719c-1.97,-4.487 -3.84802,-7.72266 -7.66602,-7.72266c-1.115,0 -2.17612,0.33231 -3.07812,0.94531c-3.977,-2.677 -8.51152,-4.13867 -13.10352,-4.13867zM32,16.19336c5.226,0 10.39936,2.10106 14.56836,5.91406c0.488,0.445 1.24545,0.40883 1.68945,-0.07617c0.445,-0.487 0.41083,-1.2425 -0.07617,-1.6875c-0.416,-0.38 -0.8492,-0.72622 -1.2832,-1.07422c1.259,-0.474 4.10214,-1.26919 7.11914,6.25781c1.246,3.108 6.81142,11.71317 7.35742,12.57617c0.415,0.912 0.625,1.88548 0.625,2.89648c0,3.859 -3.14,7 -7,7c-2.912,0 -5.50634,-1.85172 -6.52734,-4.51172c5.275,-2.444 6.72266,-6.15628 6.72266,-9.48828c0,-3.318 -1.41909,-6.99919 -3.99609,-10.36719c-0.401,-0.524 -1.15078,-0.62461 -1.67578,-0.22461c-0.524,0.402 -0.62366,1.15083 -0.22266,1.67383c2.26,2.954 3.50391,6.12097 3.50391,8.91797c0,1.892 -0.6215,3.43155 -1.6875,4.68555c-0.641,-0.417 -1.57019,-0.68555 -2.61719,-0.68555c-1.933,0 -3.5,0.895 -3.5,2c0,0.711 0.65381,1.33155 1.63281,1.68555c-4.095,1.644 -9.61781,2.12109 -14.63281,2.12109c-5.015,0 -10.53781,-0.47614 -14.63281,-2.11914c0.979,-0.355 1.63281,-0.9765 1.63281,-1.6875c0,-1.105 -1.567,-2 -3.5,-2c-1.047,0 -1.97619,0.26855 -2.61719,0.68555c-1.066,-1.254 -1.6875,-2.79355 -1.6875,-4.68555c0,-2.302 1.83688,-5.84828 3.42188,-8.36328c0.352,-0.559 0.18495,-1.29548 -0.37305,-1.64648c-0.558,-0.353 -1.29449,-0.18595 -1.64649,0.37305c-1.825,2.897 -3.79102,6.88567 -3.79102,9.63867c0,3.331 1.4458,7.04133 6.7168,9.48633c-1.023,2.685 -3.59044,4.51172 -6.52344,4.51172c-3.86,0 -7,-3.141 -7,-7c0,-1.23 0.32478,-2.43947 0.92578,-3.48047c0.218,-0.359 5.35528,-8.84219 6.73828,-11.99219c1.945,-4.431 3.12528,-5.32031 3.11328,-5.32031c0.001,-0.002 2.22227,-2.20756 4.19727,-0.85156c-0.531,0.431 -1.04983,0.88142 -1.54883,1.35742c-0.478,0.455 -0.49601,1.2105 -0.04101,1.6875c0.235,0.246 0.54923,0.36914 0.86523,0.36914c0.296,0 0.59322,-0.10908 0.82422,-0.33008c4.165,-3.969 9.60478,-6.24609 14.92578,-6.24609zM20,29c-1.10457,0 -2,1.567 -2,3.5c0,1.933 0.89543,3.5 2,3.5c1.10457,0 2,-1.567 2,-3.5c0,-1.933 -0.89543,-3.5 -2,-3.5zM44,29c-1.10457,0 -2,1.567 -2,3.5c0,1.933 0.89543,3.5 2,3.5c1.10457,0 2,-1.567 2,-3.5c0,-1.933 -0.89543,-3.5 -2,-3.5zM28.5,34c-1.378,0 -2.5,1.121 -2.5,2.5c0,1.379 1.122,2.5 2.5,2.5c0.304,0 0.61823,-0.10312 0.99023,-0.32812c1.441,-0.876 3.57339,-0.881 5.02539,0c0.368,0.224 0.68037,0.32813 0.98438,0.32813c1.378,0 2.5,-1.121 2.5,-2.5c0,-1.379 -1.122,-2.5 -2.5,-2.5c-0.552,0 -1,0.447 -1,1c0,0.553 0.448,1 1,1c0.276,0 0.5,0.225 0.5,0.5c0,0.242 -0.17139,0.44423 -0.40039,0.49023c-0.015,-0.009 -0.03088,-0.01834 -0.04687,-0.02734c-2.079,-1.259 -5.03561,-1.25695 -7.09961,-0.00195c-0.017,0.01 -0.03478,0.0213 -0.05078,0.0293c-0.23,-0.045 -0.40234,-0.24823 -0.40234,-0.49023c0,-0.275 0.224,-0.5 0.5,-0.5c0.552,0 1,-0.447 1,-1c0,-0.553 -0.448,-1 -1,-1z"></path></g></g>
                                    </svg>
                                    <p class="mt-4 text-lg font-semibold">Start typing to search series</p>
                                </div>
                            @elseif(strlen($query) > 2)
                                @if($results->isEmpty())
                                    <p class="mt-2 text-gray-500">No results found...</p>
                                @else
                                    <div class="max-h-[400px] overflow-y-auto mt-12 scrollbar-hidden">
                                        <ul class="flex flex-wrap gap-4">
                                            @foreach($results as $series)
                                                <li
                                                    wire:click="setSelectedIndex({{ $series->id }})"
                                                    class="animate-fade-in max-w-xs rounded-lg bg-white p-3 shadow-lg hover:shadow-md transition cursor-pointer border-2"
                                                    style="{{ isset($selectedSeries['id']) && $series->id === $selectedSeries['id'] ? 'border-color: #00897B;' : 'border-color: transparent;' }}"
                                                >
                                                    <div class="h-48 mb-2 rounded-md overflow-hidden flex shadow-lg">
                                                        <img
                                                            src="{{ asset($series->cover_image) }}"
                                                            alt="{{ $series->title }}"
                                                            class="min-w-[150px] object-cover"
                                                        />
                                                    </div>
                                                    <h3 class="text-md font-semibold truncate">{{ $series->title }}</h3>
                                                    <p class="text-sm text-gray-600">{{ $series->type }}</p>
                                                    <p class="text-sm text-gray-500 mt-1">⭐ {{ number_format($series->score, 1) }}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @else
                        <div class="flex gap-8 flex-col md:flex-row">
                            <div class="w-full md:w-2/3 bg-white p-6 shadow-lg rounded-xl">
                                <form wire:submit.prevent="submit">
                                    <div class="flex flex-col gap-6">
                                        <div>
                                            <x-form-label for="title" text="Series Title" />
                                            <x-form-input
                                                id="title"
                                                name="selectedSeries.title"
                                                :readOnly="true"
                                                model="selectedSeries.title"
                                            />
                                        </div>
                                        <div>
                                            <x-form-label for="type" text="Series Type" />
                                            <x-form-input
                                                id="type"
                                                name="selectedSeries.type"
                                                :readOnly="true"
                                                model="selectedSeries.type"
                                            />
                                        </div>
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
                                                    :disabled="$selectedSeries['aired_start_date'] > now()"
                                                    model="form.episodes"
                                                >
                                                    <x-form-option text="Select episodes" />
                                                    @foreach(range(0, $selectedSeries['episodes']) as $episode)
                                                        <x-form-option value="{{ $episode }}" text="{{ $episode }}" />
                                                    @endforeach
                                                </x-form-select>
                                            </div>
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="score" text="Score" />
                                                <x-form-select
                                                    id="score"
                                                    name="form.score"
                                                    :disabled="$selectedSeries['aired_start_date'] > now()"
                                                    model="form.score"
                                                >
                                                    <x-form-option text="Select your score" />
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
                                                    :readOnly="$selectedSeries['aired_start_date'] > now()"
                                                    model="form.start_date"
                                                />
                                            </div>
                                            <div class="w-full md:w-1/2">
                                                <x-form-label for="end_date" text="End date" />
                                                <x-form-input
                                                    id="end_date"
                                                    type="date"
                                                    name="form.end_date"
                                                    :readOnly="$selectedSeries['aired_start_date'] > now()"
                                                    
                                                    model="form.end_date"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="w-full md:w-1/3 rounded-md overflow-hidden flex items-center justify-center">
                                <img
                                    src="{{ asset($selectedSeries['cover_image']) }}"
                                    alt="{{ $selectedSeries['title'] }}"
                                    class="max-h-full max-w-full object-contain"
                                />
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-4 flex items-center justify-between pt-4 space-x-4">
                    <x-primary-button
                        type="button"
                        :text="$stepCount === 0 ? 'Cancel' : 'Back'"
                        class="min-w-[100px] text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto text-center dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 shadow-sm transition-colors duration-150 cursor-pointer"
                        click="previousStep"
                    />
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 rounded-full transition-all duration-300 {{ $stepCount === 0 ? 'bg-teal-600' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                        <div class="w-2 h-2 rounded-full transition-all duration-300 {{ $stepCount === 1 ? 'bg-teal-600' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                    </div>
                    <x-primary-button
                        :type="$stepCount === 0 ? 'button' : 'submit'"
                        :text="$stepCount === 0 ? 'Next' : 'Submit'"
                        :disabled="is_null($selectedSeries)"
                        class="min-w-[100px] px-5 py-2.5 text-white bg-teal-600 hover:bg-teal-700 
                               font-medium rounded-lg text-sm text-center 
                               dark:bg-teal-600 dark:hover:bg-teal-500
                               inline-flex items-center gap-3 justify-center cursor-pointer"
                        click="nextStep"
                    />
                </div>
            </div>
        </div>
    @endif
</div>