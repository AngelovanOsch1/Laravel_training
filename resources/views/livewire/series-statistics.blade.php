<div class="my-10 flex w-full flex-col rounded-xl bg-white px-6 py-6 text-center shadow-lg shadow-[#c0c0c0]">
    <h3 class="text-xl font-bold mb-4 text-left">Anime Statistics</h3>
    <div class="grid grid-cols-1 gap-y-3 text-sm text-gray-700 w-full max-w-md">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-green-500"></span>
                <span>Watching</span>
            </div>
            <span>{{ $total_series_watching }}</span>
        </div>
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-blue-500"></span>
                <span>Completed</span>
            </div>
            <span>{{ $total_series_completed }}</span>
        </div>
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-yellow-500"></span>
                <span>On-Hold</span>
            </div>
            <span>{{ $total_series_on_hold }}</span>
        </div>
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-red-500"></span>
                <span>Dropped</span>
            </div>
            <span>{{ $total_series_dropped }}</span>
        </div>
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-gray-500"></span>
                <span>Plan to Watch</span>
            </div>
            <span>{{ $total_series_plan_on_watching }} </span>
        </div>
    </div>
    <hr class="my-6 border-t border-gray-300 w-full max-w-md" />
    <div class="grid grid-cols-1 gap-y-3 text-sm text-gray-700 w-full max-w-md">
        <div class="flex justify-between">
            <span>Total Entries</span>
            <span>{{ $total_series }}</span>
        </div>
        <div class="flex justify-between">
            <span>Episodes</span>
            <span>{{ $total_episodes }}</span>
        </div>
        <div class="flex justify-between">
            <span>Total minutes</span>
            <span>{{ $total_minutes }} </span>
        </div>
        <div class="flex justify-between">
            <span>Total hours</span>
            <span>{{ number_format($total_hours, 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span>Total days</span>
            <span>{{ number_format($total_days, 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span>Total weeks</span>
            <span>{{ number_format($total_weeks, 2) }}</span>
        </div>
        <div class="flex justify-between mt-5">
            <x-nav-link href="series-list" text="Update list" />
        </div>
    </div>
</div>
