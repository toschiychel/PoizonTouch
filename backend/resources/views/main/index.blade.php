@extends('layouts.main')

@section('content')
    @include('includes.main.header')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @include('includes.main.info-boxes')

            <section class="connectedSortable">

                <!-- Доходы -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1"></i>
                            Доходы за последние 30 дней
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height: 300px;">
                            <canvas id="revenue-chart-canvas"
                                data-dates="{{ $salesData['chartData']->pluck('date')->join(',') }}"
                                data-totals="{{ $salesData['chartData']->pluck('total')->join(',') }}" height="300">
                            </canvas>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <!-- Кол-во заказов -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-shopping-cart mr-1"></i>
                                    Кол-во заказов по дням
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="position: relative; height: 300px;">
                                    <canvas id="orders-chart-canvas"
                                        data-dates="{{ collect($salesData['ordersByDay'])->keys()->join(',') }}"
                                        data-counts="{{ collect($salesData['ordersByDay'])->values()->join(',') }}" height="300">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Кол-во регистраций -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-plus mr-1"></i>
                                    Регистрации пользователей
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="position: relative; height: 300px;">
                                    <canvas id="users-chart-canvas"
                                        data-dates="{{ collect($salesData['userRegistrationsByDay'])->keys()->join(',') }}"
                                        data-counts="{{ collect($salesData['userRegistrationsByDay'])->values()->join(',') }}"
                                        height="300">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                </div>

            </section>



            <!-- /.row -->
            <!-- Main row -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const salesData = {
                dates: @json($salesData['chartData']->pluck('date')),
                totals: @json($salesData['chartData']->pluck('total'))
            };

            // График доходов с фиксированной шкалой
            new Chart(
                document.getElementById('revenue-chart-canvas'), {
                    type: 'line',
                    data: {
                        labels: salesData.dates,
                        datasets: [{
                            label: 'Доход',
                            data: salesData.totals,
                            backgroundColor: 'rgba(60,141,188,0.2)',
                            borderColor: 'rgba(60,141,188,1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: (context) => `${context.parsed.y.toLocaleString()} ₽`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: {{ $salesData['meta']['maxScale'] }}, // Фиксированный максимум
                                ticks: {
                                    callback: (value) => `${value.toLocaleString()} ₽`
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                }
            );
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createLineChart = (canvasId, labels, data, label, color = 'rgba(54, 162, 235, 0.6)') => {
                const ctx = document.getElementById(canvasId).getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: label,
                            data: data,
                            backgroundColor: color,
                            borderColor: color,
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            };

            const parseData = (el, attr) => el.dataset[attr]?.split(',').map(x => x.trim());

            // Orders chart
            const ordersCanvas = document.getElementById('orders-chart-canvas');
            if (ordersCanvas) {
                const orderDates = parseData(ordersCanvas, 'dates');
                const orderCounts = parseData(ordersCanvas, 'counts').map(Number);
                createLineChart('orders-chart-canvas', orderDates, orderCounts, 'Количество заказов',
                    'rgba(255, 99, 132, 0.6)');
            }

            // Users chart
            const usersCanvas = document.getElementById('users-chart-canvas');
            if (usersCanvas) {
                const userDates = parseData(usersCanvas, 'dates');
                const userCounts = parseData(usersCanvas, 'counts').map(Number);
                createLineChart('users-chart-canvas', userDates, userCounts, 'Регистрации пользователей',
                    'rgba(75, 192, 192, 0.6)');
            }
        });
    </script>
@endsection
