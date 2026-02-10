

@extends('backend.app')
@section('content')
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="dashboard-title">
                        <i class="bi bi-speedometer2"></i>Dashboard Overview
                    </h1>
                    <p class="dashboard-subtitle">Welcome back! Here's what's happening with your business today.</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                @php
                    $consultancyOrders = getConsultancyOrders();
                    $orders = getLatestOrders();
                    $paymentStats = getConsultancyPaymentStatusCountsThisMonth();
                @endphp

                <div class="enhanced-card consultancy-card mb-4">
                    <div class="card-header-enhanced">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="bi bi-currency-rupee"></i>
                            </div>
                            <div class="header-text">
                                <h5>Latest Consultancy Payments</h5>
                                <p>Recent payment transactions</p>
                            </div>
                        </div>
                        <div class="header-badge">
                            <span class="live-indicator"></span>
                            Live
                        </div>
                    </div>
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="enhanced-table">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($consultancyOrders as $index => $order)
                                        <tr class="table-row-enhanced">
                                            <td>
                                                <div class="customer-info">
                                                    <div class="customer-avatar">
                                                        {{ strtoupper(substr($order->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                    <div class="customer-details">
                                                        <div class="customer-name">{{ $order->name ?? 'Unknown Customer' }}
                                                        </div>
                                                        <div class="customer-email">{{ $order->email ?? 'No email' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="service-tag">
                                                    {{ $order->orderFromName ?? 'General Service' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="amount-display">
                                                    ₹{{ number_format($order->net_amount ?? 0, 2) }}
                                                </div>
                                            </td>
                                            <td>
                                                @php $status = $order->paymentStatus ?? 0; @endphp
                                                @switch($status)
                                                    @case(1)
                                                        <span class="status-badge success">
                                                            <i class="bi bi-check-circle-fill"></i>
                                                            Success
                                                        </span>
                                                    @break

                                                    @case(2)
                                                        <span class="status-badge pending">
                                                            <i class="bi bi-clock-fill"></i>
                                                            Pending
                                                        </span>
                                                    @break

                                                    @case(0)
                                                        <span class="status-badge failed">
                                                            <i class="bi bi-x-circle-fill"></i>
                                                            Failed
                                                        </span>
                                                    @break

                                                    @default
                                                        <span class="status-badge unknown">
                                                            <i class="bi bi-question-circle-fill"></i>
                                                            Unknown
                                                        </span>
                                                @endswitch
                                            </td>
                                            <td class="date-info">{{ $order->createdOn ?? 'N/A' }}</td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="empty-state">
                                                    <div class="empty-content">
                                                        <i class="bi bi-inbox empty-icon"></i>
                                                        <h6>No consultancy payments found</h6>
                                                        <p>When customers make consultancy payments, they'll appear here.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer-enhanced">
                            <span class="record-count">{{ count($consultancyOrders) }} records</span>
                            <a href="{{ route('order.consultancy') }}" class="btn-view-all">
                                View All <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Latest Orders Card -->
                    <div class="enhanced-card orders-card">
                        <div class="card-header-enhanced">
                            <div class="header-content">
                                <div class="header-icon">
                                    <i class="bi bi-bag-check"></i>
                                </div>
                                <div class="header-text">
                                    <h5>Latest Orders</h5>
                                    <p>Recent order transactions</p>
                                </div>
                            </div>
                            <div class="header-badge">
                                <span class="live-indicator"></span>
                                Live
                            </div>
                        </div>
                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="enhanced-table">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Service</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $index => $order)
                                            <tr class="table-row-enhanced">
                                                <td>
                                                    <div class="customer-info">
                                                        <div class="customer-avatar">
                                                            {{ strtoupper(substr($order->name ?? 'U', 0, 1)) }}
                                                        </div>
                                                        <div class="customer-details">
                                                            <div class="customer-name">{{ $order->name ?? 'Unknown Customer' }}
                                                            </div>
                                                            <div class="customer-email">{{ $order->email ?? 'No email' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="service-tag">
                                                        {{ $order->orderFromName ?? 'General Service' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="amount-display">
                                                        ₹{{ number_format($order->amount ?? 0, 2) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @php $status = $order->paymentStatus ?? 0; @endphp
                                                    @switch($status)
                                                        @case(1)
                                                            <span class="status-badge success">
                                                                <i class="bi bi-check-circle-fill"></i>
                                                                Success
                                                            </span>
                                                        @break

                                                        @case(2)
                                                            <span class="status-badge pending">
                                                                <i class="bi bi-clock-fill"></i>
                                                                Pending
                                                            </span>
                                                        @break

                                                        @case(0)
                                                            <span class="status-badge failed">
                                                                <i class="bi bi-x-circle-fill"></i>
                                                                Failed
                                                            </span>
                                                        @break

                                                        @default
                                                            <span class="status-badge unknown">
                                                                <i class="bi bi-question-circle-fill"></i>
                                                                Unknown
                                                            </span>
                                                    @endswitch
                                                </td>
                                                <td class="date-info">{{ $order->createdOn ?? 'N/A' }}</td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="empty-state">
                                                        <div class="empty-content">
                                                            <i class="bi bi-inbox empty-icon"></i>
                                                            <h6>No orders found</h6>
                                                            <p>When customers place orders, they'll appear here.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer-enhanced">
                                <span class="record-count">{{ count($orders) }} records</span>
                                <a href="{{ route('order.index') }}" class="btn-view-all">
                                    View All <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Analytics Card -->
                        <div class="enhanced-card analytics-card mb-3">
                            <div class="card-header-enhanced">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bi bi-pie-chart-fill"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5>Payment Analytics</h5>
                                        <p>Consultancy Status</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="consultancyChart" class="chart-canvas"></canvas>
                            </div>
                            <div class="chart-legend">
                                <div class="legend-item">
                                    <span class="legend-color success"></span>
                                    <span class="legend-text">Success ({{ $paymentStats->paid ?? 0 }})</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color pending"></span>
                                    <span class="legend-text">Pending ({{ $paymentStats->pending ?? 0 }})</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-color failed"></span>
                                    <span class="legend-text">Failed ({{ $paymentStats->failed ?? 0 }})</span>
                                </div>
                            </div>
                            <div class="card-footer-enhanced">
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>Status for this month
                                </small>
                            </div>
                        </div>

                        <div class="stats-container">
                            <a href="{{ route('rent.index') }}" class="stats-card-link">
                                <div class="premium-stats-card rent-card">
                                    <div class="stats-content">
                                        <div class="stats-header">
                                            <div class="stats-icon rent-icon">
                                                <i class="bi bi-cash-coin"></i>
                                            </div>
                                            <div class="stats-trend">
                                                <i class="bi bi-arrow-up-right"></i>
                                            </div>
                                        </div>
                                        <div class="stats-body">
                                            <h2 class="stats-number">{{ getRentCount() ?? 0 }}</h2>
                                            <h6 class="stats-title">Rent Receipts</h6>
                                            <span class="stats-badge success-badge">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                Active
                                            </span>
                                        </div>
                                    </div>
                                    <div class="stats-progress">
                                        <div class="progress-fill rent-progress"></div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('order.index') }}" class="stats-card-link">
                                <div class="premium-stats-card orders-card">
                                    <div class="stats-content">
                                        <div class="stats-header">
                                            <div class="stats-icon orders-icon">
                                                <i class="bi bi-truck"></i>
                                            </div>
                                            <div class="stats-trend">
                                                <i class="bi bi-arrow-up-right"></i>
                                            </div>
                                        </div>
                                        <div class="stats-body">
                                            <h2 class="stats-number">{{ getOrdersCount() ?? 0 }}</h2>
                                            <h6 class="stats-title">Total Orders</h6>
                                            <span class="stats-badge primary-badge">
                                                <i class="bi bi-graph-up me-1"></i>
                                                All time
                                            </span>
                                        </div>
                                    </div>
                                    <div class="stats-progress">
                                        <div class="progress-fill orders-progress"></div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('services.index') }}" class="stats-card-link">
                                <div class="premium-stats-card users-card">
                                    <div class="stats-content">
                                        <div class="stats-header">
                                            <div class="stats-icon users-icon">
                                                <i class="bi bi-gear-fill"></i>
                                            </div>
                                            <div class="stats-trend">
                                                <i class="bi bi-arrow-up-right"></i>
                                            </div>
                                        </div>
                                        <div class="stats-body">
                                            <h2 class="stats-number">{{ getServiceCount() ?? 0 }}</h2>
                                            <h6 class="stats-title">Services</h6>
                                            <span class="stats-badge info-badge">
                                                <i class="bi bi-gear-fill me-1"></i>
                                                Services
                                            </span>
                                        </div>
                                    </div>
                                    <div class="stats-progress">
                                        <div class="progress-fill users-progress"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            {{-- ================= CORRECTED SCRIPT ================= --}}
            @if (isset($paymentStats))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {

                        // --- Logic for Doughnut Chart ---
                        const canvas = document.getElementById('consultancyChart');
                        if (canvas) {
                            const chartData = {
                                labels: ['Success', 'Pending', 'Failed'],
                                values: [
                                    {{ $paymentStats->paid ?? 0 }},
                                    {{ $paymentStats->pending ?? 0 }},
                                    {{ $paymentStats->failed ?? 0 }},
                                ]
                            };

                            const total = chartData.values.reduce((acc, value) => acc + value, 0);

                            // Only render the chart if there is data to show.
                            if (total > 0) {
                                const ctx = canvas.getContext('2d');
                                new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: chartData.labels,
                                        datasets: [{
                                            data: chartData.values,
                                            backgroundColor: [
                                                'rgba(34, 197, 94, 0.8)',
                                                'rgba(245, 158, 11, 0.8)',
                                                'rgba(239, 68, 68, 0.8)'
                                            ],
                                            borderColor: [
                                                'rgba(34, 197, 94, 1)',
                                                'rgba(245, 158, 11, 1)',
                                                'rgba(239, 68, 68, 1)'
                                            ],
                                            borderWidth: 3,
                                            hoverBackgroundColor: [
                                                'rgba(34, 197, 94, 1)',
                                                'rgba(245, 158, 11, 1)',
                                                'rgba(239, 68, 68, 1)'
                                            ],
                                            hoverBorderWidth: 4
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        cutout: '65%',
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            tooltip: {
                                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                                titleColor: '#fff',
                                                bodyColor: '#fff',
                                                borderColor: 'rgba(255, 255, 255, 0.1)',
                                                borderWidth: 1,
                                                cornerRadius: 12,
                                                padding: 12,
                                                callbacks: {
                                                    label: function(context) {
                                                        const label = context.label || '';
                                                        const value = context.parsed;
                                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                                        return `${label}: ${value} (${percentage}%)`;
                                                    }
                                                }
                                            }
                                        },
                                        animation: {
                                            animateRotate: true,
                                            animateScale: true,
                                            duration: 1500,
                                            easing: 'easeOutQuart'
                                        }
                                    }
                                });
                            }
                        }

                        // --- Logic for Animated Counters ---
                        const counters = document.querySelectorAll('.stats-number');
                        counters.forEach(counter => {
                            const target = parseInt(counter.textContent, 10) || 0;
                            if (target === 0) return; // Don't animate if target is 0

                            counter.textContent = '0'; // Start display from 0
                            let current = 0;
                            const increment = target / 75; // Control animation speed
                            const timer = setInterval(() => {
                                current += increment;
                                if (current >= target) {
                                    counter.textContent = target;
                                    clearInterval(timer);
                                } else {
                                    counter.textContent = Math.floor(current);
                                }
                            }, 20); // Update interval
                        });
                    });
                </script>
            @endif
        @endsection
