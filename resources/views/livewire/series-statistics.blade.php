<div class="my-10 flex w-full rounded-xl bg-white px-6 py-6 text-center shadow-lg shadow-[#c0c0c0]">
    <div class="flex flex-1 flex-col">
        <h3 class="text-xl font-bold mb-8 text-left">Anime Statistics</h3>
        <div class="grid grid-cols-1 gap-y-3 text-sm text-gray-700 w-full max-w-md">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-green-500"></span>
                    <span>Watching</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['watching']->count }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-blue-500"></span>
                    <span>Completed</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['completed']->count }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-yellow-500"></span>
                    <span>On-Hold</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['onHold']->count }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-red-500"></span>
                    <span>Dropped</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['dropped']->count }}</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-gray-500"></span>
                    <span>Plan to Watch</span>
                </div>
                <span>{{ $totalSeriesStatusCounts['planToWatch']->count }}</span>
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
            {{-- <div class="text-xl font-bold mb-8 text-center">Series Status Chart</div>
            <canvas id="chartDoughnut" class="w-90 h-90 mx-auto"></canvas> --}}
             <div wire:ignore>
    <canvas id="seriesChart" width="800" height="400"></canvas>
</div>


        </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', () => {
        const ctx = document.getElementById('seriesChart');

        const data = @json($totalSeriesStatusCounts);
        console.log(data);
        // Convert object to arrays
        const labels = Object.values(data).map(item => item.name);
        const values = Object.values(data).map(item => item.count);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Series by Status',
                    data: values,
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.5)',   // green - Watching
                        'rgba(59, 130, 246, 0.5)',  // blue - Completed
                        'rgba(234, 179, 8, 0.5)',   // yellow - On-Hold
                        'rgba(239, 68, 68, 0.5)',   // red - Dropped
                        'rgba(107, 114, 128, 0.5)', // gray - Plan to Watch
                    ],
                    borderColor: [
                        'rgba(34, 197, 94, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(107, 114, 128, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    });
</script>
@endpush
