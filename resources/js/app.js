import './bootstrap';
import { Chart, DoughnutController, ArcElement, Tooltip, Legend } from 'chart.js';

window.toggleBodyScroll = function(showModal) {
    if (showModal) {
        const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
        document.body.style.paddingRight = scrollBarWidth + 'px';
        document.body.classList.add('overflow-hidden');
    } else {
        document.body.style.paddingRight = '';
        document.body.classList.remove('overflow-hidden');
    }
}

// Chart.register(DoughnutController, ArcElement, Tooltip, Legend);

// document.addEventListener('DOMContentLoaded', function () {
//     const ctx = document.getElementById('chartDoughnut').getContext('2d');
//     const chart = new Chart(ctx, {
//         type: 'doughnut',
//         data: {
//             labels: ["Watching", "Completed", "On-Hold", "Dropped", "Plan to Watch"],
//             datasets: [{
//                 data: [
//                     window.animeStats.watching,
//                     window.animeStats.completed,
//                     window.animeStats.onHold,
//                     window.animeStats.dropped,
//                     window.animeStats.planToWatch
//                 ],
//                 backgroundColor: ["#22c55e", "#3b82f6", "#eab308", "#ef4444", "#6b7280"],
//                 hoverOffset: 10,
//             }]
//         },
//         options: {
//             cutout: '70%',
//             plugins: {
//                 legend: { display: false },
//                 tooltip: {
//                     displayColors: false,
//                     callbacks: {
//                         label: ctx => `${ctx.label} ${ctx.parsed}`,
//                         title: () => '',
//                     },
//                     bodyFont: { size: 12, weight: 'bold' }
//                 }
//             }
//         }
//     });
// });
