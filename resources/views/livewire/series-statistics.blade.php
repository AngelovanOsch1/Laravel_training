<div class="my-10 flex w-full rounded-xl bg-white px-6 py-6 text-center shadow-lg shadow-[#c0c0c0]">
    <div class="flex flex-1 flex-col">
        <h3 class="text-xl font-bold mb-8 text-left">Anime Statistics</h3>
        <div class="grid grid-cols-1 gap-y-3 text-sm text-gray-700 w-full max-w-md">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-green-500"></span>
                    <span>Watching</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['watching']->count ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-blue-500"></span>
                    <span>Completed</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['completed']->count ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-yellow-500"></span>
                    <span>On-Hold</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['onHold']->count ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-red-500"></span>
                    <span>Dropped</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['dropped']->count ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-gray-500"></span>
                    <span>Plan to Watch</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['planToWatch']->count ?? 0 }}</span>
            </div>
        </div>

        <hr class="my-6 border-t border-gray-300 w-full max-w-md" />

        <div class="grid grid-cols-1 gap-y-3 text-sm text-gray-700 w-full max-w-md">
            <div class="flex justify-between">
                <span>Total Entries</span>
                <span>{{ $totalWatchTime->totalSeries }}</span>
            </div>
            <div class="flex justify-between">
                <span>Total minutes</span>
                <span>{{ $totalWatchTime->totalMinutes }}</span>
            </div>
            <div class="flex justify-between">
                <span>Total hours</span>
                <span>{{ number_format($totalWatchTime->totalHours, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Total days</span>
                <span>{{ number_format($totalWatchTime->totalDays, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Total weeks</span>
                <span>{{ number_format($totalWatchTime->totalWeeks, 2) }}</span>
            </div>
            <div class="flex justify-between mt-5">
                <x-nav-link href="{{ route('series-list', ['id' => $user->id]) }}" :text="$user->id === auth()->id() ? 'Update list' : 'View list'" />
            </div>
        </div>
    </div>

    <div class="flex flex-col flex-1">
        <div class="text-xl font-bold mb-8 text-center"> {{ collect($totalSeriesStatusCounts)->every(fn($item) => $item->count === 0) ? '' : 'Series Status Chart' }}</div>
        <div wire:ignore>
            <canvas id="chartDoughnut" class="w-90 h-90 mx-auto"></canvas>
        </div>
    </div>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

@script
<script>
    const seriesStatusCounts = @json(
        $totalSeriesStatusCounts->map(fn($status) => [
            'name' => $status->name,
            'count' => $status->count,
        ])->values()
    );

    const labels = seriesStatusCounts.map(item => item.name);
    const values = seriesStatusCounts.map(item => item.count);

    const ctx = document.getElementById('chartDoughnut');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: [
                    "#22c55e",
                    "#3b82f6",
                    "#eab308",
                    "#ef4444",
                    "#6b7280"
                ],
                hoverOffset: 10,
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    displayColors: false,
                    callbacks: {
                        label: ctx => `${ctx.label} ${ctx.parsed}`,
                        title: () => '',
                    },
                    bodyFont: { size: 12, weight: 'bold' }
                }
            }
        }
    });
</script>
@endscript
