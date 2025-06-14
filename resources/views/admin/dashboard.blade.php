@extends('layouts.admin')

@section('title', 'Админ-панель')

@section('content')
    <style>
        .admin-dashboard {
            max-width: 1400px; /* Увеличим контейнер для больших графиков */
            margin: 0 auto;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .admin-dashboard h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #003366;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
        }

        .card-body {
            padding: 30px;
            text-align: center;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .card-text {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 25px;
            color: #FFFFFF;
            letter-spacing: 1px;
        }

        .btn-light {
            background-color: #E6F0FF;
            color: #0055A5;
            font-weight: 600;
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            box-shadow: 0 3px 10px rgb(0 0 0 / 0.1);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-light:hover {
            background-color: #0055A5;
            color: #FFFFFF;
        }

        /* Цвета для карточек (вдохновленные mashina.kg) */
        .bg-categories {
            background: linear-gradient(135deg, #0055A5 0%, #337AB7 100%);
            color: #FFFFFF !important;
        }

        .bg-products {
            background: linear-gradient(135deg, #28A745 0%, #5CB85C 100%);
            color: #FFFFFF !important;
        }

        .bg-orders {
            background: linear-gradient(135deg, #FF5733 0%, #FF8C66 100%);
            color: #FFFFFF !important;
        }

        .bg-profit {
            background: linear-gradient(135deg, #6C757D 0%, #9EA2A7 100%);
            color: #FFFFFF !important;
        }

        .bg-new-orders {
            background: linear-gradient(135deg, #343A40 0%, #5A6268 100%);
            color: #FFFFFF !important;
        }

        .charts-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px; /* Увеличим отступ между графиками */
            justify-content: space-between;
            margin-top: 40px;
        }

        .chart-container {
            flex: 0 1 calc(50% - 15px); /* Два графика в ряд */
            padding: 20px;
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
            max-width: 700px; /* Увеличенный размер */
        }

        .chart-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #003366;
            margin-bottom: 20px;
            text-align: center;
        }

        canvas {
            max-width: 100%;
            height: 400px !important; /* Увеличенная высота */
        }

        @media (max-width: 992px) {
            .chart-container {
                flex: 0 1 100%; /* Один график в ряд на планшетах */
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .card-text {
                font-size: 2.8rem;
            }

            .card-title {
                font-size: 1.3rem;
            }

            .admin-dashboard h1 {
                font-size: 2rem;
            }

            .chart-title {
                font-size: 1.5rem;
            }

            canvas {
                height: 300px !important; /* Меньшая высота на мобильных */
            }
        }
    </style>

    <div class="admin-dashboard">
        <h1>Админ-панель</h1>

        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('admin.categories.index') }}" class="card bg-categories text-white text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-list-ul"></i> Категории</h5>
                        <p class="card-text">{{ $categoriesCount }}</p>
                        <span class="btn btn-light">Управление категориями</span>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('admin.products.index') }}" class="card bg-products text-white text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-box-seam"></i> Товары</h5>
                        <p class="card-text">{{ $productsCount }}</p>
                        <span class="btn btn-light">Управление товарами</span>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('admin.orders.index') }}" class="card bg-orders text-white text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-cart-check"></i> Заказы</h5>
                        <p class="card-text">{{ $totalCount }}</p>
                        <span class="btn btn-light">Управление заказами</span>
                    </div>
                </a>
            </div>

            <div class="col-md-6">
                <div class="card bg-profit text-white">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-currency-dollar"></i> Общая прибыль</h5>
                        <p class="card-text">{{ number_format($totalProfit, 2, '.', ' ') }} сом</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-new-orders text-white">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-bell"></i> Новые заказы сегодня</h5>
                        <p class="card-text">{{ $newOrdersToday }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Графики в сетке -->
        <div class="charts-grid">
            <!-- График заказов за неделю -->
            <div class="chart-container">
                <h2 class="chart-title">Количество заказов за последние 7 дней</h2>
                <canvas id="ordersChart"></canvas>
            </div>

            <!-- График продаж за неделю -->
            <div class="chart-container">
                <h2 class="chart-title">Продажи за последние 7 дней (сом)</h2>
                <canvas id="weeklySalesChart"></canvas>
            </div>

            <!-- График продаж за месяц -->
            <div class="chart-container">
                <h2 class="chart-title">Продажи за текущий месяц (сом)</h2>
                <canvas id="monthlySalesChart"></canvas>
            </div>

            <!-- Круговая диаграмма продаж по категориям -->
            <div class="chart-container">
                <h2 class="chart-title">Продажи по категориям (сом)</h2>
                @if(count($categoryLabels) > 0)
                    <canvas id="categorySalesChart"></canvas>
                @else
                    <p class="text-center text-muted">Нет данных для отображения</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Подключение Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // График заказов за неделю
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'line',
            data: {
                labels: @json($weekLabels),
                datasets: [{
                    label: 'Количество заказов',
                    data: @json($ordersData),
                    backgroundColor: 'rgba(0, 85, 165, 0.2)', // #0055A5
                    borderColor: 'rgba(0, 85, 165, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Фиксированная высота
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Количество заказов'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Дата'
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

        // График продаж за неделю
        const weeklySalesCtx = document.getElementById('weeklySalesChart').getContext('2d');
        new Chart(weeklySalesCtx, {
            type: 'bar',
            data: {
                labels: @json($weekLabels),
                datasets: [{
                    label: 'Продажи (сом)',
                    data: @json($weeklySalesData),
                    backgroundColor: 'rgba(40, 167, 69, 0.8)', // #28A745
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Фиксированная высота
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Сумма продаж (сом)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('ru-RU') + ' сом';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Дата'
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

        // График продаж за месяц
        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(monthlySalesCtx, {
            type: 'line',
            data: {
                labels: @json($monthLabels),
                datasets: [{
                    label: 'Продажи (сом)',
                    data: @json($monthlySalesData),
                    backgroundColor: 'rgba(255, 87, 51, 0.2)', // #FF5733
                    borderColor: 'rgba(255, 87, 51, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Фиксированная высота
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Сумма продаж (сом)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('ru-RU') + ' сом';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Дата'
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

        // Круговая диаграмма продаж по категориям
        const categorySalesCtx = document.getElementById('categorySalesChart')?.getContext('2d');
        if (categorySalesCtx) {
            new Chart(categorySalesCtx, {
                type: 'pie',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        label: 'Продажи по категориям (сом)',
                        data: @json($categorySalesData),
                        backgroundColor: [
                            'rgba(0, 85, 165, 0.8)', // #0055A5
                            'rgba(40, 167, 69, 0.8)', // #28A745
                            'rgba(255, 87, 51, 0.8)', // #FF5733
                            'rgba(108, 117, 125, 0.8)', // #6C757D
                            'rgba(52, 58, 64, 0.8)', // #343A40
                            'rgba(51, 122, 183, 0.8)', // #337AB7
                            'rgba(92, 184, 92, 0.8)' // #5CB85C
                        ],
                        borderColor: '#FFFFFF',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Фиксированная высота
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw.toLocaleString('ru-RU');
                                    return `${label}: ${value} сом`;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection
