@extends('layouts.app')

@section('content')
<div class="max-w-full">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard</h1>

    <!-- Сетка для графиков -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- График заказов по месяцам (занимает всю ширину) -->
        <div class="lg:col-span-4 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Заказы по месяцам</h2>
            <canvas id="ordersChart" height="80"></canvas>
        </div>

        <!-- Второй ряд: 2 графика по половине ширины -->
        <div class="lg:col-span-2 bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Товары по категориям</h3>
            <canvas id="categoriesChart" height="200"></canvas>
        </div>

        <div class="lg:col-span-2 bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Статистика 2</h3>
            <p class="text-gray-600">Здесь будет график</p>
        </div>

        <!-- Третий ряд: ещё 2 графика по половине ширины -->
        <div class="lg:col-span-2 bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Статистика 3</h3>
            <p class="text-gray-600">Здесь будет график</p>
        </div>

        <div class="lg:col-span-2 bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Статистика 4</h3>
            <p class="text-gray-600">Здесь будет график</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Количество заказов',
                data: @json($orderData),
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });

    // График товаров по категориям
    const ctx2 = document.getElementById('categoriesChart').getContext('2d');
    const categoriesChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: @json($categoryNames),
            datasets: [{
                label: 'Количество товаров',
                data: @json($categoryProductCounts),
                backgroundColor: @json($categoryColors),
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection
