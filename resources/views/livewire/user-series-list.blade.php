<div class="max-w-6xl mx-auto my-10 px-6 py-6 bg-white rounded-xl shadow-lg shadow-[#e0e0e0]">
    <livewire:add-series-to-your-list />

    <div class="flex items-center justify-between mb-6">
        @if (auth()->id() === $user->id)
            <h2 class="text-2xl font-bold text-gray-800">My Series List</h2>
            <x-primary-button type="button" click="openAddSeriesToYourListModal" text="Create" icon="plus" />
        @else
            <h2 class="text-2xl font-bold text-gray-800">Series List</h2>
        @endif
    </div>

    <div class="overflow-x-auto rounded-lg min-h-[200px]">
        <div class="relative flex flex-col text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
            <x-table>
                <x-table-thead>
                    <x-table-tr>
                        <x-table-th>
                            <p class="text-sm antialiased text-white">
                                #
                            </p>
                        </x-table-th>
                        <x-table-th>
                            <p class="text-sm antialiased text-white">
                                Cover
                            </p>
                        </x-table-th>
                        <x-table-th class="p-4" :cursorPointer="true" click="sortBy('title')">
                            <div class="flex items-stretch gap-2">
                                <p class="text-sm antialiased text-white">
                                    Title
                                </p>
                                <x-table-sort-icon :active="$sortField === 'title'" :direction="$sortDirection" />
                            </div>
                        </x-table-th>
                        <x-table-th>
                            <p class="text-sm antialiased text-white">
                                Status
                            </p>
                        </x-table-th>
                        <x-table-th class="p-4" :cursorPointer="true" click="sortBy('start_date')">
                            <div class="flex items-stretch gap-2">
                                <p class="text-sm antialiased text-white">
                                    Start date & End date
                                </p>
                                <x-table-sort-icon :active="$sortField === 'start_date'" :direction="$sortDirection" />
                            </div>
                        </x-table-th>
                        <x-table-th class="p-4" :cursorPointer="true" click="sortBy('episode_count')">
                            <div class="flex items-stretch gap-2">
                                <p class="text-sm antialiased text-white">
                                    Episodes
                                </p>
                                <x-table-sort-icon :active="$sortField === 'episode_count'" :direction="$sortDirection" />
                            </div>
                        </x-table-th>
                        <x-table-th class="p-4" :cursorPointer="true" click="sortBy('score')">
                            <div class="flex items-stretch gap-2">
                                <p class="text-sm antialiased text-white">
                                    Score
                                </p>
                                <x-table-sort-icon :active="$sortField === 'score'" :direction="$sortDirection" />
                            </div>
                        </x-table-th>
                        <x-table-th>
                            <p class="text-sm antialiased text-white">
                                Actions
                            </p>
                        </x-table-th>
                    </x-table-tr>
                </x-table-thead>
                <x-table-tbody>
                    @forelse ($seriesList as $entry)
                        <x-table-tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                            <x-table-td class="p-4 font-black">{{ $loop->iteration }}</x-table-td>
                            <x-table-td>
                                <img src="{{ asset($entry->cover_image) }}" alt="{{ $entry->title }}"
                                    class="w-18 h-25 object-cover rounded-md" />
                            </x-table-td>
                            <x-table-td>
                                <p>
                                    {{ $entry->title }}
                                </p>
                            </x-table-td>
                            <x-table-td>
                                <p>
                                    {{ $entry->pivot->seriesStatus->name }}
                                </p>
                            </x-table-td>
                            <x-table-td>
                                <p>
                                    {{ \Carbon\Carbon::parse($entry->pivot->start_date)->format('M Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($entry->pivot->end_date)->format('M Y') }}
                                </p>
                            </x-table-td>
                            <x-table-td>
                                <p>
                                    {{ $entry->pivot->episode_count }}
                                </p>
                            </x-table-td>
                            <x-table-td>
                                <div class="flex items-center justify-center gap-2 h-full -ml-[25px]">
                                    <img src="{{ asset('storage/images/star.svg') }}" class="w-7 h-7" alt="Star Icon">
                                    <span>{{ $entry->pivot->score }}</span>
                                </div>
                            </x-table-td>
                            @if (auth()->id() === $user->id)
                                <x-table-td>
                                    <div class="flex items-center justify-center gap-2">
                                        <x-primary-button type="button" icon="edit"
                                            click="openEditSeriesModal({{ $entry->id }})"
                                            class="bg-blue-500 hover:bg-blue-600 text-white rounded p-2 text-xs shadow-md w-8 h-8 flex items-center justify-center" />
                                        <x-primary-button type="button" icon="trash"
                                            click="openDeleteSeriesModal({{ $entry->id }})"
                                            class="bg-red-500 hover:bg-red-600 text-white rounded p-2 text-xs shadow-md w-8 h-8 flex items-center justify-center" />
                                    </div>
                                </x-table-td>
                            @endif
                        </x-table-tr>
                    @empty
                        <x-table-tr>
                            <x-table-td colspan="9">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100"
                                        height="100" viewBox="0,0,256,256" style="fill:#4D4D4D;">
                                        <g fill="#00897b" fill-rule="nonzero" stroke="none" stroke-width="1"
                                            stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10"
                                            stroke-dasharray="" stroke-dashoffset="0" font-family="none"
                                            font-weight="none" font-size="none" text-anchor="none"
                                            style="mix-blend-mode: normal">
                                            <g transform="scale(4,4)">
                                                <path
                                                    d="M32,6.96289c-0.505,0 -0.91211,0.40811 -0.91211,0.91211v1.82617c-0.001,0.504 0.40711,0.91406 0.91211,0.91406c0.505,0 0.91211,-0.41006 0.91211,-0.91406v-1.82617c0,-0.504 -0.40711,-0.91211 -0.91211,-0.91211zM26.91992,7.63086c-0.078,0 -0.15928,0.00925 -0.23828,0.03125c-0.487,0.131 -0.77648,0.63114 -0.64648,1.11914l0.47461,1.76367c0.131,0.488 0.63114,0.77653 1.11914,0.64453c0.487,-0.13 0.77453,-0.63019 0.64453,-1.11719l-0.47266,-1.76563c-0.109,-0.408 -0.47686,-0.67578 -0.88086,-0.67578zM37.08008,7.63086c-0.403,0 -0.77186,0.26778 -0.88086,0.67578l-0.47266,1.76367c-0.131,0.488 0.15853,0.98914 0.64453,1.11914c0.487,0.132 0.98814,-0.15653 1.11914,-0.64453l0.47266,-1.76563c0.131,-0.488 -0.15948,-0.98814 -0.64648,-1.11914c-0.079,-0.02 -0.15833,-0.0293 -0.23633,-0.0293zM22.18164,9.5918c-0.155,0 -0.31108,0.04005 -0.45508,0.12305c-0.437,0.252 -0.58698,0.81009 -0.33398,1.24609l0.91406,1.58203c0.253,0.437 0.81209,0.58598 1.24609,0.33398c0.437,-0.252 0.58698,-0.81009 0.33398,-1.24609l-0.91211,-1.58203c-0.17,-0.293 -0.47697,-0.45703 -0.79297,-0.45703zM41.81445,9.59375c-0.316,0 -0.62201,0.16303 -0.79102,0.45703l-0.91406,1.58203c-0.252,0.433 -0.10106,0.99309 0.33594,1.24609c0.436,0.251 0.99409,0.10202 1.24609,-0.33398l0.91406,-1.58203c0.252,-0.437 0.10202,-0.99409 -0.33398,-1.24609c-0.143,-0.083 -0.30103,-0.12305 -0.45703,-0.12305zM32,13.80664c-4.602,0 -9.26825,1.52191 -13.28125,4.25391c-0.932,-0.679 -2.04275,-1.06055 -3.21875,-1.06055c-1.432,0 -4.50002,-0.00034 -7.66602,7.72266c-1.256,3.063 -6.56686,11.67139 -6.63086,11.77539c-0.787,1.363 -1.20312,2.91995 -1.20312,4.50195c0,4.963 4.038,9 9,9c3.758,0 7.07058,-2.32472 8.39258,-5.76172c3.443,1.205 8.16742,1.95508 14.60742,1.95508c6.441,0 11.16638,-0.75008 14.60938,-1.95508c1.323,3.404 4.65962,5.76172 8.39063,5.76172c4.962,0 9,-4.037 9,-9c0,-1.325 -0.28189,-2.60287 -0.83789,-3.79687l-0.0625,-0.11328c-0.059,-0.093 -5.92495,-9.34519 -7.25195,-12.36719c-1.97,-4.487 -3.84802,-7.72266 -7.66602,-7.72266c-1.115,0 -2.17612,0.33231 -3.07812,0.94531c-3.977,-2.677 -8.51152,-4.13867 -13.10352,-4.13867zM32,16.19336c5.226,0 10.39936,2.10106 14.56836,5.91406c0.488,0.445 1.24545,0.40883 1.68945,-0.07617c0.445,-0.487 0.41083,-1.2425 -0.07617,-1.6875c-0.416,-0.38 -0.8492,-0.72622 -1.2832,-1.07422c1.259,-0.474 4.10214,-1.26919 7.11914,6.25781c1.246,3.108 6.81142,11.71317 7.35742,12.57617c0.415,0.912 0.625,1.88548 0.625,2.89648c0,3.859 -3.14,7 -7,7c-2.912,0 -5.50634,-1.85172 -6.52734,-4.51172c5.275,-2.444 6.72266,-6.15628 6.72266,-9.48828c0,-3.318 -1.41909,-6.99919 -3.99609,-10.36719c-0.401,-0.524 -1.15078,-0.62461 -1.67578,-0.22461c-0.524,0.402 -0.62366,1.15083 -0.22266,1.67383c2.26,2.954 3.50391,6.12097 3.50391,8.91797c0,1.892 -0.6215,3.43155 -1.6875,4.68555c-0.641,-0.417 -1.57019,-0.68555 -2.61719,-0.68555c-1.933,0 -3.5,0.895 -3.5,2c0,0.711 0.65381,1.33155 1.63281,1.68555c-4.095,1.644 -9.61781,2.12109 -14.63281,2.12109c-5.015,0 -10.53781,-0.47614 -14.63281,-2.11914c0.979,-0.355 1.63281,-0.9765 1.63281,-1.6875c0,-1.105 -1.567,-2 -3.5,-2c-1.047,0 -1.97619,0.26855 -2.61719,0.68555c-1.066,-1.254 -1.6875,-2.79355 -1.6875,-4.68555c0,-2.302 1.83688,-5.84828 3.42188,-8.36328c0.352,-0.559 0.18495,-1.29548 -0.37305,-1.64648c-0.558,-0.353 -1.29449,-0.18595 -1.64649,0.37305c-1.825,2.897 -3.79102,6.88567 -3.79102,9.63867c0,3.331 1.4458,7.04133 6.7168,9.48633c-1.023,2.685 -3.59044,4.51172 -6.52344,4.51172c-3.86,0 -7,-3.141 -7,-7c0,-1.23 0.32478,-2.43947 0.92578,-3.48047c0.218,-0.359 5.35528,-8.84219 6.73828,-11.99219c1.945,-4.431 3.12528,-5.32031 3.11328,-5.32031c0.001,-0.002 2.22227,-2.20756 4.19727,-0.85156c-0.531,0.431 -1.04983,0.88142 -1.54883,1.35742c-0.478,0.455 -0.49601,1.2105 -0.04101,1.6875c0.235,0.246 0.54923,0.36914 0.86523,0.36914c0.296,0 0.59322,-0.10908 0.82422,-0.33008c4.165,-3.969 9.60478,-6.24609 14.92578,-6.24609zM20,29c-1.10457,0 -2,1.567 -2,3.5c0,1.933 0.89543,3.5 2,3.5c1.10457,0 2,-1.567 2,-3.5c0,-1.933 -0.89543,-3.5 -2,-3.5zM44,29c-1.10457,0 -2,1.567 -2,3.5c0,1.933 0.89543,3.5 2,3.5c1.10457,0 2,-1.567 2,-3.5c0,-1.933 -0.89543,-3.5 -2,-3.5zM28.5,34c-1.378,0 -2.5,1.121 -2.5,2.5c0,1.379 1.122,2.5 2.5,2.5c0.304,0 0.61823,-0.10312 0.99023,-0.32812c1.441,-0.876 3.57339,-0.881 5.02539,0c0.368,0.224 0.68037,0.32813 0.98438,0.32813c1.378,0 2.5,-1.121 2.5,-2.5c0,-1.379 -1.122,-2.5 -2.5,-2.5c-0.552,0 -1,0.447 -1,1c0,0.553 0.448,1 1,1c0.276,0 0.5,0.225 0.5,0.5c0,0.242 -0.17139,0.44423 -0.40039,0.49023c-0.015,-0.009 -0.03088,-0.01834 -0.04687,-0.02734c-2.079,-1.259 -5.03561,-1.25695 -7.09961,-0.00195c-0.017,0.01 -0.03478,0.0213 -0.05078,0.0293c-0.23,-0.045 -0.40234,-0.24823 -0.40234,-0.49023c0,-0.275 0.224,-0.5 0.5,-0.5c0.552,0 1,-0.447 1,-1c0,-0.553 -0.448,-1 -1,-1z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    @if (auth()->id() === $user->id)
                                        <p class="text-gray-400 text-lg">Go add your series!</p>
                                    @else
                                        <p class="text-gray-400 text-lg">No series found.</p>
                                    @endif
                                </div>
                            </x-table-td>
                        </x-table-tr>
                    @endforelse
                </x-table-tbody>
            </x-table>
        </div>
    </div>

    <div class="mt-6">
        {{ $seriesList->links('vendor.pagination.tailwind') }}
    </div>

    <livewire:edit-series />
</div>


{{-- <table class="min-w-full text-sm text-gray-700 bg-white text-center">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider text-xs">
                <tr>
                    <th class="p-3 font-bold align-middle" wire:click="sortBy('id')">ID</th>
                    <th class="p-3 font-bold align-middle">Cover</th>
                    <th class="p-3 font-bold align-middle">Title</th>
                    <th class="p-3 font-bold align-middle">Status</th>
                    <th class="p-3 font-bold align-middle">Start Date</th>
                    <th class="p-3 font-bold align-middle">End Date</th>
                    <th class="p-3 font-bold align-middle">Episodes</th>
                    <th class="p-3 font-bold align-middle" wire:click="sortBy('score')">Score</th>
                    <th class="p-3 font-bold align-middle">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($seriesUser as $entry)
                    <tr class="border-b border-gray-300 hover:bg-gray-50 transition">
                        <td class="p-3 align-middle font-black">{{ $entry->id }}</td>
                        <td class="p-3 align-middle">
                            @if ($entry->series->cover_image)
                                <img src="{{ asset($entry->series->cover_image) }}" alt="{{ $entry->series->title }}" class="w-16 h-auto mx-auto rounded-md shadow-sm" />
                            @else
                                <span class="text-gray-400 italic">No image</span>
                            @endif
                        </td>
                        <td class="p-3 align-middle font-medium">{{ $entry->series->title }}</td>
                        <td class="p-3 align-middle">{{ $entry->seriesStatus->name }}</td>
                        <td class="p-3 align-middle">{{ \Carbon\Carbon::parse($entry->start_date)->format('F j, Y') }}</td>
                        <td class="p-3 align-middle">{{ \Carbon\Carbon::parse($entry->end_date)->format('F j, Y') }}</td>
                        <td class="p-3 align-middle">{{ $entry->episodes }}</td>
                        <td class="p-3 align-middle">{{ $entry->score }}</td>
                        <td class="p-3 align-middle">
                            <div class="flex items-center justify-center gap-2">
                                <x-primary-button
                                    type="button"
                                    icon="edit"
                                    click='openEditSeriesModal({{ $entry->id }})'
                                    class="bg-blue-500 hover:bg-blue-600 text-white rounded p-2 text-xs shadow-md w-8 h-8 flex items-center justify-center"
                                />
                                <x-primary-button
                                    type="button"
                                    icon="trash"
                                    click="deleteSeries({{ $entry->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white rounded p-2 text-xs shadow-md w-8 h-8 flex items-center justify-center"
                                />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center p-6 text-gray-500">No series found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table> --}}
