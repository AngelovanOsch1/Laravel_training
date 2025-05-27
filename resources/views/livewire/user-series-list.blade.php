<div class="max-w-5xl mx-auto my-10 px-6 py-6 bg-white rounded-xl shadow-lg shadow-[#e0e0e0]">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">My Series List</h2>
        <x-primary-button
            type="button"
            text="Add"
            click="openAddSeriesToYourListModal"
            class="px-6 py-2 bg-green-300 text-white font-semibold rounded-md shadow-md shadow-[#e0e0e0] hover:bg-green-400 hover:shadow-[#c0c0c0] cursor-pointer ml-auto"
        />
        <livewire:add-series-to-your-list />
    </div>

    <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full text-sm text-gray-700 bg-white text-center">
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
        </table>
    </div>

    <div class="mt-6">
        {{ $seriesUser->links() }}
    </div>
    <livewire:edit-series />
</div>
